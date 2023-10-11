const getPostData = (form) => {
    let formData = new FormData(form);
    let postData = new URLSearchParams();
    for(const formElem of formData){
        postData.append(formElem[0], formElem[1]);
    }
    return postData;
}