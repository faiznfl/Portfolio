// Sound engine completely disabled
class SilentSoundEngine {
    constructor() {
        this.enabled = false;
    }
    initContext() {}
    toggle() { return false; }
    playTone() {}
    playHover() {}
    playClick() {}
    playWhoosh() {}
    playSuccess() {}
}

export const sounds = new SilentSoundEngine();
