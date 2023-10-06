const lottieContainer = document.getElementById("lottie");

const lottieOptions = {
  container: lottieContainer,
  renderer: "svg",
  loop: true,
  autoplay: true,
  path: "animation/chifoumi.json",
};

const animation = lottie.loadAnimation(lottieOptions);