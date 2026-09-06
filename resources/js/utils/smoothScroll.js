let currentAnimationId = null;
let activeInterruptCleanup = null;

/**
 * Buttery smooth RAF-based scroll animator with cubic bezier easing
 * and automatic interrupt detection (wheel, touch).
 *
 * @param {string|HTMLElement|number} target Element, ID string, or vertical pixel offset
 * @param {object} options Options including offset, duration, and onComplete callback
 */
export function smoothScrollTo(target, options = {}) {
    const {
        offset = 80,
        duration = null,
        onComplete = null,
    } = options;

    let targetY = 0;

    if (typeof target === 'number') {
        targetY = target;
    } else {
        let targetElement = null;
        if (typeof target === 'string') {
            const cleanId = target.replace(/^#/, '');
            targetElement = document.getElementById(cleanId);
        } else if (target instanceof HTMLElement) {
            targetElement = target;
        }

        if (!targetElement) return;

        const bodyRect = document.body.getBoundingClientRect().top;
        const elementRect = targetElement.getBoundingClientRect().top;
        targetY = Math.max(0, elementRect - bodyRect - offset);
    }

    // Cancel previous ongoing animation if any
    if (currentAnimationId) {
        cancelAnimationFrame(currentAnimationId);
        currentAnimationId = null;
    }

    if (activeInterruptCleanup) {
        activeInterruptCleanup();
        activeInterruptCleanup = null;
    }

    const startY = window.scrollY;
    const distance = targetY - startY;

    if (Math.abs(distance) < 2) {
        if (onComplete) onComplete();
        return;
    }

    // Calculate natural duration proportional to distance: 450ms min to 850ms max
    const animDuration = duration ?? Math.min(850, Math.max(450, Math.abs(distance) * 0.22));
    const startTime = performance.now();

    // Standard easeInOutCubic curve (Material / Apple standard for long scrolls)
    const easeInOutCubic = (t) => {
        return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
    };

    // Temporarily set scrollBehavior to auto to prevent native browser engine from fighting RAF ticks
    const prevScrollBehavior = document.documentElement.style.scrollBehavior;
    document.documentElement.style.scrollBehavior = 'auto';

    const onInterrupt = () => {
        if (currentAnimationId) {
            cancelAnimationFrame(currentAnimationId);
            currentAnimationId = null;
        }
        document.documentElement.style.scrollBehavior = prevScrollBehavior;
        if (activeInterruptCleanup) {
            activeInterruptCleanup();
            activeInterruptCleanup = null;
        }
    };

    const cleanupInterrupt = () => {
        window.removeEventListener('wheel', onInterrupt);
        window.removeEventListener('touchmove', onInterrupt);
    };

    activeInterruptCleanup = cleanupInterrupt;
    window.addEventListener('wheel', onInterrupt, { passive: true });
    window.addEventListener('touchmove', onInterrupt, { passive: true });

    const step = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / animDuration, 1);
        const ease = easeInOutCubic(progress);

        window.scrollTo(0, startY + distance * ease);

        if (progress < 1) {
            currentAnimationId = requestAnimationFrame(step);
        } else {
            currentAnimationId = null;
            document.documentElement.style.scrollBehavior = prevScrollBehavior;
            if (activeInterruptCleanup) {
                activeInterruptCleanup();
                activeInterruptCleanup = null;
            }
            if (onComplete) onComplete();
        }
    };

    currentAnimationId = requestAnimationFrame(step);
}
