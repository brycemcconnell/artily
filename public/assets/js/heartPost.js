function heartPost(postEl, isHearted) {
    const postId = postEl.getAttribute("data-post-id");
    console.log(isHearted)
    var data = {
        "post_id": postId
    };

    if (isHearted == false) {
        console.log('Attempting to add heart');

        fetch('http://artily.saber/api/posts/addheart', {
            method: "POST",
            credentials: "same-origin",
            body: JSON.stringify(data),
            headers:{
                'Content-Type': 'application/json'
            }
        }).then(res => {
            if (res.ok) {
                console.log(res);
                return res.json();
            }
            throw new Error('Network response not ok');
        }).then(response => {
            console.log('Success:', response);
            postEl.classList.add('item-heart_active');
        })
        .catch(err => console.log('Error:', err)); 
    } else {
        console.log('Attempting to remove heart');

        fetch('http://artily.saber/api/posts/removeheart', {
            method: "POST",
            credentials: "same-origin",
            body: JSON.stringify(data),
            headers:{
                'Content-Type': 'application/json'
            }
        }).then(res => {
            if (res.ok) {
                console.log(res);
                return res.json();
            }
            throw new Error('Network response not ok');
        }).then(response => {
            console.log('Success:', response);
            postEl.classList.remove('item-heart_active');
        })
        .catch(err => console.log('Error:', err)); 
    }
    
}
