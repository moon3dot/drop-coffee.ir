let widgets = document.querySelectorAll('.sidebar-mode-2');

if (widgets.length){
    let animationTime = 100;
    widgets.forEach(function (element){
        let titleElement = element.querySelectorAll('.sidebar-widget-title, .wp-block-heading');
        if (!titleElement.length){
            element.classList.add('sidebar-widget-padding');
        }
        animationTime += 100;
        setTimeout(function (){
            element.style.opacity = 1;
        }, animationTime);
    })
}