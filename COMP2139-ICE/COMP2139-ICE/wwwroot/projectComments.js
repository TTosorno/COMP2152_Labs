async function loadComments(projectId) {
    const response = await fetch(`/api/ProjectManagement/ProjectComment/GetComments/${projectId}`);
    const comments = await response.json();

    const commentsList = document.getElementById("commentsList");
    commentsList.innerHTML = ""; // Clear existing list

    comments.forEach(comment => {
        const date = new Date(comment.createdDate).toLocaleString();
        const div = document.createElement("div");
        div.classList.add("border", "p-2", "mb-2", "rounded", "bg-light");
        div.innerHTML = `
            <p class="mb-1">${comment.content}</p>
            <small class="text-muted">Posted on: ${date}</small>
        `;
        commentsList.appendChild(div);
    });
}

async function addComment(projectId) {
    const content = document.getElementById("commentContent").value;
    if (!content) return alert("Comment cannot be empty");

    const response = await fetch('/api/ProjectManagement/ProjectComment/AddComment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ projectId: projectId, content: content })
    });

    if (response.ok) {
        document.getElementById("commentContent").value = ""; // Clear box
        loadComments(projectId); // Refresh list
    } else {
        alert("Failed to post comment");
    }
}