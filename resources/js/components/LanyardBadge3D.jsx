import React, { useEffect, useRef, useState, Suspense } from 'react';
import * as THREE from 'three';
import { Canvas, extend, useFrame, useThree } from '@react-three/fiber';
import { useGLTF, useTexture, Text, Environment, Lightformer } from '@react-three/drei';
import {
    BallCollider,
    CuboidCollider,
    RigidBody,
    useRopeJoint,
    useSphericalJoint,
    Physics
} from '@react-three/rapier';
import { MeshLineGeometry, MeshLineMaterial } from 'meshline';

extend({ MeshLineGeometry, MeshLineMaterial });

// Preload assets for instantaneous rendering
try {
    useGLTF.preload('/assets/3d/card.glb');
    useTexture.preload('/assets/images/tag_texture.png');
    useTexture.preload('/assets/images/card_texture_faiz.png?v=clean');
} catch (e) {
    // Ignore in SSR/non-browser contexts
}

const segmentProps = {
    type: 'dynamic',
    canSleep: true,
    colliders: false,
    angularDamping: 2,
    linearDamping: 2,
};

function Band({ profile, maxSpeed = 50, minSpeed = 10 }) {
    const band = useRef(null);
    const fixed = useRef(null);
    const j1 = useRef(null);
    const j2 = useRef(null);
    const j3 = useRef(null);
    const card = useRef(null);

    const vec = useRef(new THREE.Vector3()).current;
    const ang = useRef(new THREE.Vector3()).current;
    const rot = useRef(new THREE.Vector3()).current;
    const dir = useRef(new THREE.Vector3()).current;

    const [dragged, drag] = useState(false);
    const [hovered, hover] = useState(false);

    const { nodes, materials } = useGLTF('/assets/3d/card.glb');
    const strapTexture = useTexture('/assets/images/tag_texture.png');
    const cardTexture = useTexture('/assets/images/card_texture_faiz.png?v=clean');

    const [curve] = useState(
        () =>
            new THREE.CatmullRomCurve3([
                new THREE.Vector3(),
                new THREE.Vector3(),
                new THREE.Vector3(),
                new THREE.Vector3(),
            ])
    );

    useRopeJoint(fixed, j1, [[0, 0, 0], [0, 0, 0], 1]);
    useRopeJoint(j1, j2, [[0, 0, 0], [0, 0, 0], 1]);
    useRopeJoint(j2, j3, [[0, 0, 0], [0, 0, 0], 1]);

    useSphericalJoint(j3, card, [
        [0, 0, 0],
        [0, 1.74, 0],
    ]);

    useEffect(() => {
        if (hovered) {
            document.body.style.cursor = dragged ? 'grabbing' : 'grab';
            return () => {
                document.body.style.cursor = 'auto';
            };
        }
        return () => {
            document.body.style.cursor = 'auto';
        };
    }, [hovered, dragged]);

    // Global pointerup to ensure drag release is captured anywhere
    useEffect(() => {
        const handleGlobalPointerUp = () => {
            drag(false);
        };
        window.addEventListener('pointerup', handleGlobalPointerUp);
        return () => {
            window.removeEventListener('pointerup', handleGlobalPointerUp);
        };
    }, []);

    useFrame((state, delta) => {
        if (
            !fixed.current ||
            !j1.current ||
            !j2.current ||
            !j3.current ||
            !band.current ||
            !card.current
        ) {
            return;
        }

        if (dragged) {
            vec.set(state.pointer.x, state.pointer.y, 0.5).unproject(state.camera);
            dir.copy(vec).sub(state.camera.position).normalize();
            vec.add(dir.multiplyScalar(state.camera.position.length()));
            [card, j1, j2, j3, fixed].forEach((ref) => ref.current?.wakeUp());
            card.current?.setNextKinematicTranslation({
                x: vec.x - dragged.x,
                y: vec.y - dragged.y,
                z: vec.z - dragged.z,
            });
        }

        if (fixed.current) {
            const [j1Lerped, j2Lerped] = [j1, j2].map((ref) => {
                if (ref.current) {
                    const lerped = new THREE.Vector3().copy(ref.current.translation());
                    const clampedDistance = Math.max(
                        0.1,
                        Math.min(1, lerped.distanceTo(ref.current.translation()))
                    );

                    return lerped.lerp(
                        ref.current.translation(),
                        delta * (minSpeed + clampedDistance * (maxSpeed - minSpeed))
                    );
                }
                return null;
            });

            curve.points[0].copy(j3.current.translation());
            curve.points[1].copy(j2Lerped ?? j2.current.translation());
            curve.points[2].copy(j1Lerped ?? j1.current.translation());
            curve.points[3].copy(fixed.current.translation());
            band.current.geometry.setPoints(curve.getPoints(32));

            ang.copy(card.current.angvel());
            rot.copy(card.current.rotation());
            card.current.setAngvel(
                { x: ang.x, y: ang.y - rot.y * 0.25, z: ang.z },
                false
            );
        }
    });

    curve.curveType = 'chordal';
    strapTexture.wrapS = strapTexture.wrapT = THREE.RepeatWrapping;
    strapTexture.colorSpace = THREE.SRGBColorSpace;

    cardTexture.flipY = false;
    cardTexture.colorSpace = THREE.SRGBColorSpace;
    cardTexture.anisotropy = 16;

    return (
        <>
            <group position={[0, 4.9, 0]}>
                <RigidBody ref={fixed} {...segmentProps} type="fixed" />
                <RigidBody position={[0.5, 0, 0]} ref={j1} {...segmentProps}>
                    <BallCollider args={[0.1]} />
                </RigidBody>
                <RigidBody position={[1, 0, 0]} ref={j2} {...segmentProps}>
                    <BallCollider args={[0.1]} />
                </RigidBody>
                <RigidBody position={[1.5, 0, 0]} ref={j3} {...segmentProps}>
                    <BallCollider args={[0.1]} />
                </RigidBody>

                <RigidBody
                    position={[2, 0, 0]}
                    ref={card}
                    {...segmentProps}
                    type={dragged ? 'kinematicPosition' : 'dynamic'}
                >
                    <CuboidCollider args={[0.96, 1.35, 0.01]} />
                    <group
                        scale={2.7}
                        position={[0, -1.5, -0.05]}
                        onPointerOver={() => hover(true)}
                        onPointerOut={() => hover(false)}
                        onPointerUp={(e) => {
                            if (e.target?.releasePointerCapture) {
                                e.target.releasePointerCapture(e.pointerId);
                            }
                            drag(false);
                        }}
                        onPointerDown={(e) => {
                            if (e.target?.setPointerCapture) {
                                e.target.setPointerCapture(e.pointerId);
                            }
                            if (card.current) {
                                drag(
                                    new THREE.Vector3()
                                        .copy(e.point)
                                        .sub(vec.copy(card.current.translation()))
                                );
                            }
                        }}
                    >
                        {/* 3D Card Mesh with Faiz Naufal's Custom High-Res Texture */}
                        <mesh geometry={nodes.card.geometry}>
                            <meshPhysicalMaterial
                                map={cardTexture}
                                map-anisotropy={16}
                                clearcoat={1}
                                clearcoatRoughness={0.15}
                                roughness={0.3}
                                metalness={0.25}
                            />
                        </mesh>

                        {/* Metal Clip and Clamp */}
                        <mesh
                            geometry={nodes.clip.geometry}
                            material={materials.metal}
                            material-roughness={0.3}
                        />
                        <mesh geometry={nodes.clamp.geometry} material={materials.metal} />
                    </group>
                </RigidBody>
            </group>

            {/* MeshLine Physics Band with Faiz Naufal Lanyard Ribbon */}
            <mesh ref={band}>
                <meshLineGeometry />
                <meshLineMaterial
                    color="white"
                    depthTest={false}
                    resolution={new THREE.Vector2(2, 1)}
                    useMap={1}
                    map={strapTexture}
                    repeat={new THREE.Vector2(-3, 1)}
                    lineWidth={1}
                />
            </mesh>
        </>
    );
}

function Loader() {
    return (
        <div className="absolute inset-0 flex flex-col items-center justify-center gap-3 text-blue-400 font-mono text-xs">
            <div className="w-8 h-8 border-2 border-blue-500/30 border-t-blue-400 rounded-full animate-spin"></div>
            <span>Loading 3D Physics Lanyard...</span>
        </div>
    );
}

class CanvasErrorBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = { hasError: false };
    }
    static getDerivedStateFromError() {
        return { hasError: true };
    }
    componentDidCatch(error, errorInfo) {
        console.warn('WebGL/3D Canvas fallback triggered:', error, errorInfo);
    }
    render() {
        if (this.state.hasError) {
            return this.props.fallback;
        }
        return this.props.children;
    }
}

function ResponsiveCamera() {
    const { camera, size } = useThree();

    useEffect(() => {
        const w = window.innerWidth;
        if (w < 640) {
            // Mobile screens: bring camera closer so lanyard badge card is substantially larger
            camera.position.set(0, 0.6, 10.8);
        } else if (w < 1024) {
            // Tablet screens: moderately closer
            camera.position.set(0, 0.7, 12.0);
        } else {
            // Desktop screens
            camera.position.set(0, 0.75, 13.8);
        }
        camera.updateProjectionMatrix();
    }, [size.width, size.height, camera]);

    return null;
}

export default function LanyardBadge3D({ profile, fallbackComponent }) {
    return (
        <div className="relative w-full h-[420px] sm:h-[500px] lg:h-[700px] flex items-center justify-center select-none overflow-visible">
            <CanvasErrorBoundary fallback={fallbackComponent || null}>
                <Suspense fallback={<Loader />}>
                    {/* Responsive canvas container with touchAction pan-y to preserve mobile scroll */}
                    <div
                        className="absolute inset-0 -left-[20%] -right-[20%] sm:-left-[45%] sm:-right-[45%] lg:-left-[85%] lg:-right-[85%] -top-[15%] -bottom-[15%] overflow-visible pointer-events-auto"
                        style={{ touchAction: 'pan-y' }}
                    >
                        <Canvas
                            camera={{ position: [0, 0.75, 13.8], fov: 33 }}
                            style={{ backgroundColor: 'transparent', width: '100%', height: '100%' }}
                            gl={{ alpha: true, antialias: true }}
                        >
                            <ResponsiveCamera />
                            <ambientLight intensity={Math.PI} />
                            <Physics
                                debug={false}
                                interpolate
                                gravity={[0, -40, 0]}
                                timeStep={1 / 60}
                            >
                                <Band profile={profile} />
                            </Physics>
                            <Environment blur={0.75}>
                                <Lightformer
                                    intensity={2}
                                    color="white"
                                    position={[0, -1, 5]}
                                    rotation={[0, 0, Math.PI / 3]}
                                    scale={[100, 0.1, 1]}
                                />
                                <Lightformer
                                    intensity={3}
                                    color="white"
                                    position={[-1, -1, 1]}
                                    rotation={[0, 0, Math.PI / 3]}
                                    scale={[100, 0.1, 1]}
                                />
                                <Lightformer
                                    intensity={3}
                                    color="white"
                                    position={[1, 1, 1]}
                                    rotation={[0, 0, Math.PI / 3]}
                                    scale={[100, 0.1, 1]}
                                />
                                <Lightformer
                                    intensity={10}
                                    color="white"
                                    position={[-10, 0, 14]}
                                    rotation={[0, Math.PI / 2, Math.PI / 3]}
                                    scale={[100, 10, 1]}
                                />
                            </Environment>
                        </Canvas>
                    </div>
                </Suspense>
            </CanvasErrorBoundary>
        </div>
    );
}
