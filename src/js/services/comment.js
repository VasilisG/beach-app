const addComment = (data) => {
    return fetch(
        COMMENT_ADD_URL,
        {
            method: 'POST',
            body: data
        }
    )
    .then(response => response.json());
}

const deleteComment = (data) => {
    return fetch(
        COMMENT_DELETE_URL,
        {
            method: 'POST',
            body: data
        }
    )
    .then(response => response.json());
}

const getCommentsBy = (paramName, paramValue) => {
    return fetch(
        COMMENT_GET_URL + new URLSearchParams({
            'param_name': paramName,
            'param_value': paramValue
        }),
        {
            method: 'GET'
        }
    )
    .then(response => response.json());
}