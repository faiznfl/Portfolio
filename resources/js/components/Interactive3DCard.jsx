import React, { useState, useRef, useEffect, useCallback } from 'react';

/**
 * Interactive3DCard: High-performance, flexible physical 3D ID Badge Card with:
 * - Real-time 60-120fps Cursor 3D Perspective Tilt
 * - Elastic Drag & Spring Pendulum Physics (Grab & swing like a real lanyard badge)
 * - True multi-layer 3D Parallax Depth (preserve-3d + translateZ)
 * - Dynamic Holographic Specular Sheen & Glare
 * - Double-Sided 3D Card Flip (Front: Dev ID Badge / Back: Security Credential & Tech Clearance)
 * - Natural idle breathing/floating sway when unhovered
 */
export default function Interactive3DCard({ profile }) {
    const cardRef = useRef(null);
    const containerRef = useRef(null);
    const strapPathRef = useRef(null);
    const strapStitchRef = useRef(null);
    const clipRef = useRef(null);
    const animFrameRef = useRef(null);

    // Physics & transform state
    const [isFlipped, setIsFlipped] = useState(false);
    const [isDragging, setIsDragging] = useState(false);
    const [isHovered, setIsHovered] = useState(false);

    // Current animated values (interpolated for butter-smooth 60-120fps)
    const currentRotX = useRef(0);
    const currentRotY = useRef(0);
    const currentPosX = useRef(0);
    const currentPosY = useRef(0);
    const currentVelX = useRef(0);
    const currentVelY = useRef(0);

    // Target values based on cursor / drag
    const targetRotX = useRef(0);
    const targetRotY = useRef(0);
    const targetPosX = useRef(0);
    const targetPosY = useRef(0);

    // Glare coordinates (percentage 0-100)
    const [glare, setGlare] = useState({ x: 50, y: 50, opacity: 0 });

    // Drag start tracking
    const dragStart = useRef({ x: 0, y: 0, initialPosX: 0, initialPosY: 0 });

    // Spring physics animation loop
    const updatePhysics = useCallback(() => {
        const springK = 0.075;   // Spring stiffness
        const damping = 0.82;    // Velocity damping
        const lerpFactor = 0.12; // Rotation interpolation

        if (isDragging) {
            // Directly follow drag target with elastic dampening
            currentPosX.current += (targetPosX.current - currentPosX.current) * 0.35;
            currentPosY.current += (targetPosY.current - currentPosY.current) * 0.35;

            // Tilt in direction of drag
            const dragRotX = Math.max(-25, Math.min(25, -currentPosY.current * 0.25));
            const dragRotY = Math.max(-25, Math.min(25, currentPosX.current * 0.25));
            currentRotX.current += (dragRotX - currentRotX.current) * 0.2;
            currentRotY.current += (dragRotY - currentRotY.current) * 0.2;
        } else {
            // Spring simulation back to equilibrium (or hover target)
            const forceX = (targetPosX.current - currentPosX.current) * springK;
            const forceY = (targetPosY.current - currentPosY.current) * springK;

            currentVelX.current = (currentVelX.current + forceX) * damping;
            currentVelY.current = (currentVelY.current + forceY) * damping;

            currentPosX.current += currentVelX.current;
            currentPosY.current += currentVelY.current;

            // Rotation smoothly tracks target
            currentRotX.current += (targetRotX.current - currentRotX.current) * lerpFactor;
            currentRotY.current += (targetRotY.current - currentRotY.current) * lerpFactor;
        }

        // Apply 3D transform to card DOM node
        const px = currentPosX.current;
        const py = currentPosY.current;
        const rx = currentRotX.current;
        const ry = currentRotY.current + (isFlipped ? 180 : 0);

        if (cardRef.current) {
            cardRef.current.style.transform = `
                translate3d(${px}px, ${py}px, 0px)
                rotateX(${rx}deg)
                rotateY(${ry}deg)
            `;
        }

        // Dynamic flexible ribbon strap physics & curvature (shorter & organic)
        const strapEndX = px * 0.55;
        const strapEndY = Math.min(12, Math.max(-8, py * 0.22));

        const x0 = 80;
        const y0 = 0;
        const x1 = 80 + strapEndX;
        const y1 = 44 + strapEndY; // short, compact height ~44px

        // Control points create realistic cloth curve / bowing
        const cx1 = x0 + strapEndX * 0.2;
        const cy1 = y0 + 16;
        const cx2 = x0 + strapEndX * 0.85;
        const cy2 = y1 - 10;

        const pathData = `M ${x0} ${y0} C ${cx1} ${cy1}, ${cx2} ${cy2}, ${x1} ${y1}`;

        if (strapPathRef.current) {
            strapPathRef.current.setAttribute('d', pathData);
        }
        if (strapStitchRef.current) {
            strapStitchRef.current.setAttribute('d', pathData);
        }
        if (clipRef.current) {
            const tangentAngle = (Math.atan2(x1 - cx2, y1 - cy2) * 180) / Math.PI;
            clipRef.current.style.transform = `translate3d(${strapEndX}px, ${strapEndY}px, 0px) rotate(${-tangentAngle * 0.65}deg)`;
        }

        animFrameRef.current = requestAnimationFrame(updatePhysics);
    }, [isDragging, isFlipped]);

    useEffect(() => {
        animFrameRef.current = requestAnimationFrame(updatePhysics);
        return () => {
            if (animFrameRef.current) cancelAnimationFrame(animFrameRef.current);
        };
    }, [updatePhysics]);

    // Pointer movement (Hover 3D Tilt)
    const handlePointerMove = (e) => {
        if (isDragging) {
            const deltaX = e.clientX - dragStart.current.x;
            const deltaY = e.clientY - dragStart.current.y;

            // Rubber-band resistance curve
            const maxDrag = 90;
            const clampedX = Math.sign(deltaX) * Math.min(maxDrag, Math.abs(deltaX) * 0.85);
            const clampedY = Math.sign(deltaY) * Math.min(maxDrag, Math.abs(deltaY) * 0.85);

            targetPosX.current = clampedX;
            targetPosY.current = clampedY;
            return;
        }

        if (!cardRef.current) return;
        const rect = cardRef.current.getBoundingClientRect();
        const cardX = e.clientX - rect.left;
        const cardY = e.clientY - rect.top;

        const normalizedX = (cardX / rect.width) * 2 - 1; // -1 to 1
        const normalizedY = (cardY / rect.height) * 2 - 1; // -1 to 1

        const maxTilt = 18;
        targetRotX.current = -normalizedY * maxTilt;
        targetRotY.current = normalizedX * maxTilt;

        setGlare({
            x: Math.round((cardX / rect.width) * 100),
            y: Math.round((cardY / rect.height) * 100),
            opacity: 0.65,
        });
    };

    const handlePointerEnter = () => {
        setIsHovered(true);
    };

    const handlePointerLeave = () => {
        setIsHovered(false);
        if (!isDragging) {
            targetRotX.current = 0;
            targetRotY.current = 0;
            targetPosX.current = 0;
            targetPosY.current = 0;
            setGlare(prev => ({ ...prev, opacity: 0 }));
        }
    };

    const handlePointerDown = (e) => {
        // Only trigger on primary mouse button or touch
        if (e.button !== 0 && e.pointerType === 'mouse') return;
        setIsDragging(true);
        dragStart.current = {
            x: e.clientX,
            y: e.clientY,
            initialPosX: currentPosX.current,
            initialPosY: currentPosY.current,
        };

        // Capture pointer so dragging outside card continues smoothly
        if (e.target.setPointerCapture) {
            e.target.setPointerCapture(e.pointerId);
        }
    };

    const handlePointerUp = (e) => {
        if (!isDragging) return;
        setIsDragging(false);

        // Add release impulse for natural pendulum swing back
        currentVelX.current = -currentPosX.current * 0.18;
        currentVelY.current = -currentPosY.current * 0.18;

        targetPosX.current = 0;
        targetPosY.current = 0;
        targetRotX.current = 0;
        targetRotY.current = 0;

        if (e.target.releasePointerCapture) {
            try {
                e.target.releasePointerCapture(e.pointerId);
            } catch {
                // Ignore if already released
            }
        }
    };

    const toggleFlip = (e) => {
        if (e) e.stopPropagation();
        setIsFlipped(prev => !prev);
    };

    return (
        <div 
            ref={containerRef}
            className="w-full relative flex flex-col items-center justify-center select-none"
            style={{ perspective: '1200px' }}
            onPointerMove={handlePointerMove}
            onPointerEnter={handlePointerEnter}
            onPointerLeave={handlePointerLeave}
        >
            {/* Soft Ambient Backlight */}
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-96 bg-gradient-to-tr from-ps-primary/25 via-indigo-600/20 to-cyan-500/20 rounded-full blur-3xl pointer-events-none transform scale-110"></div>

            {/* Top Anchor Mount */}
            <div className="w-14 h-2 rounded-full bg-slate-800/90 dark:bg-black/90 border border-slate-600/40 dark:border-white/20 shadow-sm flex items-center justify-center mb-[-2px] z-10">
                <div className="w-6 h-0.5 rounded-full bg-slate-500/80 dark:bg-slate-400/80"></div>
            </div>

            {/* Flexible Dynamic Curved Ribbon Lanyard (Shorter & Fluid) */}
            <svg 
                className="w-[160px] h-[46px] overflow-visible pointer-events-none z-10 -my-0.5"
                viewBox="0 0 160 46"
            >
                <defs>
                    <linearGradient id="lanyardGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stopColor="#181d2e" />
                        <stop offset="25%" stopColor="#28324e" />
                        <stop offset="50%" stopColor="#3c4b75" />
                        <stop offset="75%" stopColor="#28324e" />
                        <stop offset="100%" stopColor="#141724" />
                    </linearGradient>
                    <filter id="strapShadow" x="-30%" y="-30%" width="160%" height="160%">
                        <feDropShadow dx="0" dy="3" stdDeviation="3" floodColor="#000000" floodOpacity="0.6" />
                    </filter>
                </defs>

                {/* Main Woven Ribbon Body (20px wide, bends flexibly) */}
                <path
                    ref={strapPathRef}
                    d="M 80 0 C 80 15, 80 32, 80 44"
                    fill="none"
                    stroke="url(#lanyardGrad)"
                    strokeWidth="20"
                    strokeLinecap="square"
                    filter="url(#strapShadow)"
                />

                {/* Cybernetic Stitched Edge / Center Accent (Flexes with strap) */}
                <path
                    ref={strapStitchRef}
                    d="M 80 0 C 80 15, 80 32, 80 44"
                    fill="none"
                    stroke="#00d4ff"
                    strokeWidth="1.8"
                    strokeDasharray="3 3"
                    strokeOpacity="0.8"
                />
            </svg>

            {/* Compact Metal Swivel Clasp / Clip with Ring that aligns with strap & slot */}
            <div 
                ref={clipRef}
                className="relative z-10 -mt-1 mb-1 flex flex-col items-center pointer-events-none transition-transform duration-75 ease-out"
            >
                {/* Metal Swivel Clasp */}
                <div className="w-8 h-4 rounded-md bg-gradient-to-b from-slate-400 via-slate-200 to-slate-500 border border-white/70 shadow-md flex items-center justify-center">
                    <div className="w-4 h-1 rounded-full bg-slate-700/60"></div>
                </div>
                {/* Metal D-Ring inserting directly into badge */}
                <div className="w-5 h-3 rounded-b-full border-2 border-slate-300 -mt-1 shadow-sm bg-black/20"></div>
            </div>

            {/* Physical ID Badge Card Container with 3D Transform */}
            <div
                ref={cardRef}
                onPointerDown={handlePointerDown}
                onPointerUp={handlePointerUp}
                className={`relative w-full max-w-[300px] sm:max-w-[330px] z-20 cursor-grab active:cursor-grabbing transition-shadow duration-300 ${
                    isDragging ? 'shadow-2xl scale-[1.03]' : ''
                }`}
                style={{
                    transformStyle: 'preserve-3d',
                    willChange: 'transform',
                    touchAction: 'none',
                }}
                title="Geser / tarik kartu untuk efek 3D, klik tombol di bawah untuk membalik kartu"
            >
                {/* Dynamic Holographic Specular Glare Layer */}
                <div
                    className="absolute inset-0 rounded-[26px] pointer-events-none z-30 transition-opacity duration-300 overflow-hidden mix-blend-color-dodge"
                    style={{
                        opacity: glare.opacity,
                        background: `radial-gradient(circle at ${glare.x}% ${glare.y}%, rgba(255,255,255,0.45) 0%, rgba(56,189,248,0.25) 30%, transparent 65%)`,
                    }}
                />

                {/* Cybernetic Iridescent Edge Highlight */}
                <div
                    className="absolute inset-0 rounded-[26px] pointer-events-none z-30 transition-opacity duration-300 border border-white/25"
                    style={{
                        background: `linear-gradient(${glare.x * 3.6}deg, rgba(0,212,255,0.15) 0%, transparent 40%, rgba(147,51,234,0.15) 100%)`,
                        opacity: isHovered || isDragging ? 0.9 : 0.3,
                    }}
                />

                {/* ===================================================
                    FRONT FACE: Official Developer Access Badge
                    =================================================== */}
                <div
                    className="id-badge-card p-5 text-center shadow-2xl relative"
                    style={{
                        backfaceVisibility: 'hidden',
                        WebkitBackfaceVisibility: 'hidden',
                        transformStyle: 'preserve-3d',
                    }}
                >
                    {/* Top Badge Slot Cutout (Deep 3D) */}
                    <div 
                        className="id-badge-slot shadow-inner"
                        style={{ transform: 'translateZ(15px)' }}
                    ></div>

                    {/* Badge Header Brand */}
                    <div 
                        className="flex items-center justify-between px-2 py-1 text-[10px] font-mono text-slate-400 dark:text-gray-400 border-b border-slate-200/80 dark:border-white/10 pb-2.5 mb-3"
                        style={{ transform: 'translateZ(20px)' }}
                    >
                        <span className="text-ps-primary dark:text-cyan-400 font-bold tracking-wider">FN // 2026</span>
                        <span className="text-emerald-500 dark:text-green-400 flex items-center gap-1.5 font-semibold">
                            <span className="w-2 h-2 rounded-full bg-emerald-500 dark:bg-green-400 animate-ping"></span>
                            ACTIVE ACCESS
                        </span>
                    </div>

                    {/* Portrait Photo Inside Badge with 3D Depth */}
                    <div 
                        className="relative aspect-[3/4] w-full rounded-2xl overflow-hidden bg-slate-900 border border-slate-300/40 dark:border-white/15 shadow-2xl group"
                        style={{ transform: 'translateZ(30px)' }}
                    >
                        <img
                            src={profile?.avatar_image || '/assets/images/faiz-naufal.jpg'}
                            alt={profile?.full_name || 'Faiz Naufal'}
                            className="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105"
                            loading="eager"
                        />
                        <div className="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-transparent"></div>
                        
                        {/* Chip ID Overlay */}
                        <div className="absolute bottom-2.5 left-2.5 right-2.5 flex items-center justify-between">
                            <div className="text-[10px] font-mono font-bold text-cyan-300 tracking-widest bg-black/60 px-2 py-0.5 rounded backdrop-blur-sm border border-cyan-400/30">
                                DEV ID: #9842
                            </div>
                            <div className="text-[9px] font-mono text-slate-400 uppercase bg-black/40 px-1.5 py-0.5 rounded">
                                LEVEL 4
                            </div>
                        </div>
                    </div>

                    {/* Badge Bottom Information */}
                    <div 
                        className="pt-4 pb-1 space-y-1 text-center"
                        style={{ transform: 'translateZ(25px)' }}
                    >
                        <h3 className="text-xl font-bold text-slate-900 dark:text-white tracking-tight">
                            {profile?.full_name || 'Faiz Naufal Putra Permana'}
                        </h3>
                        <p className="text-xs text-ps-primary dark:text-cyan-300 font-medium">
                            {profile?.headline || 'Web Developer'}
                        </p>
                    </div>

                    {/* Stylized Barcode / Serial Line */}
                    <div 
                        className="pt-3 border-t border-slate-200/80 dark:border-white/10 flex items-center justify-between text-[9px] font-mono text-slate-500 dark:text-gray-400 px-1 mt-2"
                        style={{ transform: 'translateZ(18px)' }}
                    >
                        <span>SECURE ACCESS PASS</span>
                        <span className="tracking-widest font-bold">||| | |||| | |||</span>
                    </div>
                </div>

                {/* ===================================================
                    BACK FACE: Security Clearance & Tech Pass
                    =================================================== */}
                <div
                    className="id-badge-card p-5 text-center shadow-2xl absolute inset-0 flex flex-col justify-between"
                    style={{
                        backfaceVisibility: 'hidden',
                        WebkitBackfaceVisibility: 'hidden',
                        transform: 'rotateY(180deg)',
                        transformStyle: 'preserve-3d',
                    }}
                >
                    {/* Top Magnetic Strip */}
                    <div 
                        className="w-full h-8 bg-black/90 dark:bg-black rounded-lg border border-white/10 flex items-center justify-between px-3 text-[9px] font-mono text-gray-500"
                        style={{ transform: 'translateZ(15px)' }}
                    >
                        <span>TRACK-01: SYSTEM ENG</span>
                        <span>ENC-256</span>
                    </div>

                    {/* Smart IC Chip Graphic */}
                    <div 
                        className="my-3 flex items-center justify-between px-2"
                        style={{ transform: 'translateZ(25px)' }}
                    >
                        {/* Gold Security Chip */}
                        <div className="w-12 h-9 rounded-md bg-gradient-to-br from-amber-300 via-yellow-500 to-amber-600 p-1 border border-yellow-200/60 shadow-md flex flex-col justify-between">
                            <div className="w-full h-0.5 bg-amber-800/40"></div>
                            <div className="flex justify-between">
                                <div className="w-2 h-3 border-r border-amber-800/40"></div>
                                <div className="w-2 h-3 border-l border-amber-800/40"></div>
                            </div>
                            <div className="w-full h-0.5 bg-amber-800/40"></div>
                        </div>

                        {/* Contactless RFID Icon */}
                        <div className="text-right">
                            <span className="text-lg text-cyan-400">📡</span>
                            <div className="text-[8px] font-mono text-gray-400">NFC AUTHORIZED</div>
                        </div>
                    </div>

                    {/* Developer Clearance Details */}
                    <div 
                        className="p-3 rounded-xl bg-slate-900/60 dark:bg-black/50 border border-white/10 text-left space-y-2 text-[11px] font-mono"
                        style={{ transform: 'translateZ(20px)' }}
                    >
                        <div className="flex justify-between text-slate-300">
                            <span className="text-gray-400">CLEARANCE:</span>
                            <span className="text-cyan-300 font-bold">ALPHA PRODUCTION</span>
                        </div>
                        <div className="flex justify-between text-slate-300">
                            <span className="text-gray-400">DOMAIN:</span>
                            <span>Distributed Systems</span>
                        </div>
                        <div className="flex justify-between text-slate-300">
                            <span className="text-gray-400">AVAILABILITY:</span>
                            <span className="text-emerald-400 font-semibold">Ready for Ship</span>
                        </div>
                    </div>

                    {/* Quick Stats Grid */}
                    <div 
                        className="grid grid-cols-3 gap-2 text-center py-2"
                        style={{ transform: 'translateZ(20px)' }}
                    >
                        <div className="p-2 rounded-lg bg-white/5 border border-white/5">
                            <div className="text-sm font-bold text-cyan-400">5+</div>
                            <div className="text-[9px] text-gray-400 font-mono">Years Exp</div>
                        </div>
                        <div className="p-2 rounded-lg bg-white/5 border border-white/5">
                            <div className="text-sm font-bold text-indigo-400">24+</div>
                            <div className="text-[9px] text-gray-400 font-mono">Shipped</div>
                        </div>
                        <div className="p-2 rounded-lg bg-white/5 border border-white/5">
                            <div className="text-sm font-bold text-emerald-400">99.98%</div>
                            <div className="text-[9px] text-gray-400 font-mono">Uptime SLA</div>
                        </div>
                    </div>

                    {/* Back Footer Barcode */}
                    <div 
                        className="pt-2 border-t border-slate-200/80 dark:border-white/10 flex items-center justify-between text-[9px] font-mono text-gray-400 px-1"
                        style={{ transform: 'translateZ(15px)' }}
                    >
                        <span>SIG: FA-2026-PROD</span>
                        <span className="font-bold">VERIFIED OK</span>
                    </div>
                </div>
            </div>

            {/* Interactive Control Pill (Flip button & tactile interaction hint) */}
            <div className="mt-5 flex items-center gap-2.5 z-20">
                <button
                    type="button"
                    onClick={toggleFlip}
                    className="group inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-200/80 dark:bg-white/10 hover:bg-ps-primary hover:text-white dark:hover:bg-cyan-400 dark:hover:text-black border border-slate-300/80 dark:border-white/15 text-xs font-mono font-medium text-slate-800 dark:text-gray-200 shadow-lg backdrop-blur-md transition-all duration-200 active:scale-95"
                >
                    <span className="text-sm transition-transform duration-500 group-hover:rotate-180">↻</span>
                    <span>{isFlipped ? 'Lihat Tampak Depan' : 'Putar Kartu 3D'}</span>
                </button>

                <div className="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-full bg-slate-100/70 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-[11px] font-mono text-slate-500 dark:text-gray-400 backdrop-blur-sm">
                    <span>✨</span>
                    <span>Sentuh &amp; geser untuk efek fisik</span>
                </div>
            </div>
        </div>
    );
}
