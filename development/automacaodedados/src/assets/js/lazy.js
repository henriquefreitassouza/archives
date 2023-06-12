let image_collection = document.getElementsByClassName('lazy');

if ('IntersectionObserver' in window) {
  let image_observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        let image = entry.target;
        image.src = image.dataset.src;
        image.classList.remove('lazy');
        image_observer.unobserve(image);
      }
    });
  });

  for (let image of image_collection) image_observer.observe(image);
} else {
  for (let image of image_collection) {
    if (image.dataset.src) image.src = image.dataset.src;
  }
}
