const imgs = document.querySelectorAll('.img-select a');
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener('click', (event) => {
        event.preventDefault();
        console.log('hej', imgItem)
        imgId = imgItem.dataset.id;
        slideImage();
    });
});

function slideImage() {
    const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;
    console.log(displayWidth)
    document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
}



function singleImageContainer() {

}
window.addEventListener('resize', slideImage);

function countReplies() {
    let allComments = document.querySelectorAll(".single-comment-container");

    allComments.forEach(element => {
        let span = element.querySelector(".comment_replies_number");
        let replyContainer = element.querySelector('.replies-container');
        let replies = replyContainer.querySelectorAll(".single-reply-container");
        let count = 0;
        if (replies.length < 1) {
            span.textContent = count + " replies";
            span.parentNode.querySelector("i").remove();
        } else {


            for (let i = 0; i < replies.length; i++) {
                count++;
            }
            span.textContent = count + " replies";
        }

    })


}

countReplies();
let allForms = document.querySelectorAll(".reply-form");
function showReplyForm(element) {

    console.log("hej")

    allForms.forEach(form => {
        console.log(form)
        form.classList.remove("show");
    })
    let container = element.parentNode.parentNode;
    container.querySelector(".reply-form").classList.toggle("show");
}
function showReplies(element) {
    allForms.forEach(form => {
        console.log(form)
        form.classList.remove("show");
    })
    let container = element.parentNode.parentNode.parentNode;
    element.classList.toggle("active");
    container.querySelector(".replies-container").classList.toggle("show");
}


function cancelReply(element) {
    let container = element.parentNode.parentNode;
    container.querySelector(".reply-form").classList.remove("show");
}

let textarea = document.querySelectorAll(".resize-ta");

textarea.forEach(ele => {
    console.log(ele)
    ele.addEventListener("keyup", () => {
        ele.style.height = calcHeight(ele.value) + "px";
    });

})

// Dealing with Input width


// Dealing with Textarea Height
function calcHeight(value) {
    let numberOfLineBreaks = (value.match(/\n/g) || []).length;
    // min-height + lines x line-height + padding + border
    let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
    return newHeight;
}


