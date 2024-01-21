const ahuraLottieElementAnimationHandle = function (params){
    let lottieContainer = params.container;
    let lottieAnimation = bodymovin.loadAnimation({
        container: lottieContainer,
        path: params.path,
        renderer: params.renderer,
        loop: params.loop,
        autoplay: params.autoplay,
        lazyload: params.lazyload,
    });

    lottieAnimation.setSpeed(params.playSpeed);

    let isAnimationPlaying = false;
    const handleMouse = function () {
        if (!isAnimationPlaying) {
            lottieAnimation.goToAndStop(0);
            lottieAnimation.play();
            isAnimationPlaying = true;

            lottieAnimation.addEventListener('complete', function () {
                isAnimationPlaying = false;
            });
        }
    }

    if(params.trigger === 'scroll'){
        let lastScrollY = window.scrollY;

        function updateAnimationPlayback() {
            const currentScrollY = window.scrollY;
            if (currentScrollY > lastScrollY) {
                lottieAnimation.goToAndStop(lottieAnimation.currentFrame + 5, true);
            } else if (currentScrollY < lastScrollY) {
                let frames = lottieAnimation.currentFrame - 5;
                if(frames > 0){
                    lottieAnimation.goToAndStop(frames, true);
                }
            }
            lastScrollY = currentScrollY;
            requestAnimationFrame(updateAnimationPlayback);
        }

        window.addEventListener('scroll', updateAnimationPlayback);
    } else if(params.trigger === 'onclick'){
        lottieContainer.addEventListener('click', handleMouse);
    } else if(params.trigger === 'onhover'){
        lottieContainer.addEventListener('mouseover', handleMouse);
    }
}