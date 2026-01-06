// variables
const body = document.querySelector("body");
const sideBtn = document.querySelector(".sideBtn");
const sideBg = document.querySelector(".sideNav");
const x = document.querySelector(".closeNav");
// const sideLeft = document.querySelector(".sideNavLinks");

// open side navbar
sideBtn.addEventListener("click", () => {
  body.classList.add("no-scrolling");
  sideBg.classList.add("active");
});

// close side navbar
x.addEventListener("click", () => {
  body.classList.remove("no-scrolling");
  sideBg.classList.remove("active");
});

sideBtn.addEventListener("click", () => {
  console.log("clicked");
});