const backButton = document.querySelector('.back-link');
if (backButton) {
  backButton.addEventListener('click', function () {
    if (window.history.length > 1) {
      window.history.back();
    } else {
      window.location.href = '/';
    }
  });
}