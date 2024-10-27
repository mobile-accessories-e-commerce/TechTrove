function submitComment() {
    const name = document.getElementById("name").value;
    const comment = document.getElementById("comment").value;

    if (name && comment) {
        const commentUl=document.getElementById("comment-list");
        const commentLi=document.createElement("li");
        commentLi.textContent=`${name}:${comment}`;
        commentUl.appendChild(commentLi);        
    
        document.getElementById("comment-form").reset();
        alert("Thank you for your comment!");
    } else {
        alert("Please fill in all fields.");
    }
}
