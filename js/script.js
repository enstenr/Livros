let userBox = document.querySelector('.header .header-2 .user-box');

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active');
   navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .header-2 .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

window.onscroll = () =>{
   userBox.classList.remove('active');
   navbar.classList.remove('active');

   if(window.scrollY > 60){
      document.querySelector('.header .header-2').classList.add('active');
   }else{
      document.querySelector('.header .header-2').classList.remove('active');
   }
}
document.getElementById('contactForm').addEventListener('submit', function (e) {
   e.preventDefault(); // Empêche l'envoi traditionnel du formulaire

   const formData = new FormData(this); // Récupère les données du formulaire

   fetch('contact.php', {
       method: 'POST',
       body: formData
   })
   .then(response => response.text())
   .then(data => {
       // Affiche un message de succès ou gère les erreurs
       alert('Message envoyé avec succès!');
   })
   .catch(error => {
       console.error('Erreur:', error);
       alert('Une erreur est survenue. Veuillez réessayer.');
   });
});
