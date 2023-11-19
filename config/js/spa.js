// Dhr. Allen Pieter
document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('section');
  
    document.querySelector('nav').addEventListener('click', function (event) {
      event.preventDefault();
  
      const targetId = event.target.getAttribute('href').substring(1);
      sections.forEach(section => {
        section.classList.add('hidden');
      });
  
      document.getElementById(targetId).classList.remove('hidden');
    });
});  