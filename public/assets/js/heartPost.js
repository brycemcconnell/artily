const addHeartURI = `//${window.location.host}/api/posts/addheart`;
const removeHeartURI = `//${window.location.host}/api/posts/removeheart`;

/**
 * Return a promise from an uri endpoint and throw if error
 * @param {uri} uri 
 * @param {object} data 
 */
function heartPostFetch(uri, data) {
  return fetch(uri, {
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
    throw new Error(`${res.status}: ${res.statusText}`);
  })
}

/**
 * Handle sending fetch to api, and on resolution update client
 * @param {HTMLElement} postEl 
 * @param {boolean} isHearted 
 */
function heartPost(postEl, isHearted) {
  const hButton = postEl.querySelector('.js--heart');
	const hCount = postEl.querySelector('.js--heart_count');
  const postId = postEl.getAttribute("data-post-id");
  console.log(isHearted)
  var data = {
    "post_id": postId
  };

  if (isHearted == false) {

    console.log('Attempting to add heart');
    heartPostFetch(addHeartURI, data)
      .then(response => {
        console.log('Success:', response);
        hButton.classList.add('js--heart_active');
        hCount.innerHTML = Number(hCount.innerHTML) + 1;
        return response;
      })     
      .catch(err => console.error(err)); 

  } else {

    console.log('Attempting to remove heart');
    heartPostFetch(removeHeartURI, data)
      .then(response => {
        console.log('Success:', response);
        hButton.classList.remove('js--heart_active');
        hCount.innerHTML = Number(hCount.innerHTML) - 1;
      })
      .catch(err => console.error(err)); 

  }
}
