/*sticky header */
window.onscroll = ( ) =>{
    let header = document.querySelector(".header");
    header.classList.toggle('sticky',window.scrollY > 100)
}

ScrollReval({
    reset:true,
    distance: '80px',
    duration: 2000,
    delay: 200
});

/*ScrollReval().reveal('.home-content , .heading', { origin: 'top'});*/
