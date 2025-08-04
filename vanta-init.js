document.addEventListener("DOMContentLoaded", function () {
    if (typeof VANTA !== "undefined" && document.querySelector(".vanta-bg")) {
        VANTA.FOG({
            el: ".vanta-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            highlightColor: vantaOptions.highlightColor,
            midtoneColor: vantaOptions.midtoneColor,
            lowlightColor: vantaOptions.lowlightColor,
            baseColor: vantaOptions.baseColor,
            speed: parseFloat(vantaOptions.speed)
        });
    }
});
