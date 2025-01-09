const hamburger = document.getElementById("hamburger");
const nav = document.getElementsByTagName("nav")[0];

/**
 * @param {Event} e
 */
function toggleNav(e) {
  console.log(e);
  nav.style.display = nav.style.display !== "flex" ? "flex" : "" ;
}

hamburger.addEventListener('click', toggleNav);