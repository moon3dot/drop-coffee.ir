const listItems = document.querySelectorAll('.portfolio li');
const allImages = document.querySelectorAll('.portfolio .container .images');

const toggleActiveClass = active => {
    listItems.forEach(item => item.classList.remove('active'));
    active.classList.add('active');
}

const randomNumber = () => (Math.random() * (1.8 - 1.5 + 1) + 1.6) + 's';

const toggleImages = dataClass => {
    if (dataClass === 'all') {
        allImages.forEach(image => {
            image.style.display = 'block';
            image.style.animationDuration = randomNumber();
            image.classList.add('fadeInUp');
        });
    } else {
        allImages.forEach(image => {
            if(image.dataset.class === dataClass) {
                image.style.display = 'block';
                image.style.animationDuration = randomNumber();
                image.classList.add('fadeInUp');
            } else {
                image.style.display = 'none';
                image.style.animationDuration = randomNumber();
                image.classList.remove('fadeInUp');
            }
        });
    }
}

listItems.forEach(item => {
    item.addEventListener('click', () => {
        toggleActiveClass(item);
        toggleImages(item.dataset.class);
    });
});
