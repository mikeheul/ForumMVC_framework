const settings = document.querySelector(".settings");
const colorPicker = document.querySelector(".color-picker");
const circles = document.querySelectorAll(".circle");

settings.addEventListener("click", () => {
    colorPicker.classList.toggle("active");
})

circles.forEach(circle => {
    circle.addEventListener("click", () => {
        console.log(circle.dataset.color);
        document.documentElement.style.setProperty('--mainColor', circle.dataset.color);
        colorPicker.classList.toggle("active");
    });
});