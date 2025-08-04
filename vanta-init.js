document.addEventListener("DOMContentLoaded", function () {
  if (typeof VANTA === "undefined" || typeof VANTA.FOG === "undefined") return;

  // Normalize: split on comma or space, remove empty items
  const raw = vantaOptions.cssClass || '';
  const classList = raw.split(/[\s,]+/).filter(Boolean);

  classList.forEach((className) => {
    const elements = document.querySelectorAll("." + className);
    elements.forEach((el) => {
      VANTA.FOG({
        el: el,
        THREE: THREE,
        highlightColor: vantaOptions.highlightColor,
        midtoneColor: vantaOptions.midtoneColor,
        lowlightColor: vantaOptions.lowlightColor,
        baseColor: vantaOptions.baseColor,
        speed: parseFloat(vantaOptions.speed),
        blurFactor: parseFloat(vantaOptions.blurFactor),
        zoom: parseFloat(vantaOptions.zoom),
      });
    });
  });
});
