import React, { useEffect, useRef } from 'react';

export default function AmbientCanvas() {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let animationFrameId;
        const symbols = ['△', '◯', '✕', '▢'];
        const mouse = { x: -1000, y: -1000, radius: 120 };

        const resize = () => {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
        };

        resize();
        window.addEventListener('resize', resize);

        const parent = canvas.parentElement;
        const handleMouseMove = (e) => {
            const rect = canvas.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        };

        const handleMouseLeave = () => {
            mouse.x = -1000;
            mouse.y = -1000;
        };

        if (parent) {
            parent.addEventListener('mousemove', handleMouseMove);
            parent.addEventListener('mouseleave', handleMouseLeave);
        }

        const count = Math.min(Math.floor((canvas.width * canvas.height) / 30000), 22);
        const particles = [];
        for (let i = 0; i < count; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - 0.5) * 0.4,
                vy: (Math.random() - 0.5) * 0.4,
                size: Math.random() * 1.5 + 1,
                symbol: Math.random() > 0.7 ? symbols[Math.floor(Math.random() * symbols.length)] : null,
                symbolSize: Math.floor(Math.random() * 5 + 9),
                alpha: Math.random() * 0.2 + 0.1,
                angle: Math.random() * Math.PI * 2,
                vAngle: (Math.random() - 0.5) * 0.015
            });
        }

        const render = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw hairline connections
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 100) {
                        const alpha = (1 - dist / 100) * 0.12;
                        ctx.strokeStyle = `rgba(0, 102, 219, ${alpha})`;
                        ctx.lineWidth = 0.75;
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
            }

            // Draw particles & symbols
            particles.forEach((p) => {
                const mdx = mouse.x - p.x;
                const mdy = mouse.y - p.y;
                const mDist = Math.sqrt(mdx * mdx + mdy * mdy);

                if (mDist < mouse.radius) {
                    const force = (1 - mDist / mouse.radius) * 1.2;
                    p.x -= (mdx / mDist) * force;
                    p.y -= (mdy / mDist) * force;
                }

                p.x += p.vx;
                p.y += p.vy;
                p.angle += p.vAngle;

                if (p.x < 0) p.x = canvas.width;
                if (p.x > canvas.width) p.x = 0;
                if (p.y < 0) p.y = canvas.height;
                if (p.y > canvas.height) p.y = 0;

                if (p.symbol) {
                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.angle);
                    ctx.font = `${p.symbolSize}px sans-serif`;
                    ctx.fillStyle = `rgba(0, 102, 219, ${p.alpha * 0.8})`;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(p.symbol, 0, 0);
                    ctx.restore();
                } else {
                    ctx.fillStyle = `rgba(56, 159, 255, ${p.alpha})`;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            });

            animationFrameId = requestAnimationFrame(render);
        };

        render();

        return () => {
            window.removeEventListener('resize', resize);
            if (parent) {
                parent.removeEventListener('mousemove', handleMouseMove);
                parent.removeEventListener('mouseleave', handleMouseLeave);
            }
            cancelAnimationFrame(animationFrameId);
        };
    }, []);

    return <canvas ref={canvasRef} id="ambient-canvas" className="absolute inset-0 w-full h-full pointer-events-auto z-1" />;
}
