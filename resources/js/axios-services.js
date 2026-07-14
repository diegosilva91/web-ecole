window.axios = require('axios');

async function UpdateObject(route, parameters, callback)
{
    return await axios.post('/es/' + route, parameters, {
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        }
    },)
        //{headers: { Authorization: "Bearer " + token }}

        .then(async function (response) {
            return await callback(null, response.data);
        })
        .catch(async function (error) {
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                return await callback(error.response, null);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                callback(error.request, null);
            } else {
                // Something happened in setting up the request that triggered an Error
                callback(error.message, null);
            }
        });
}

function UpdateObjectApi(route, parameters, callback)
{
    axios.create({
        baseURL: process.env.APP_URL
    });
    axios.post('/api/' + route, parameters,)
        //{headers: { Authorization: "Bearer " + token }}

        .then(function (response) {
            if (response.config.headers) {
                // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
            }
            callback(null, response.data);
        })
        .catch(function (error) {
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                callback(error.response, null);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                callback(error.request, null);
            } else {
                // Something happened in setting up the request that triggered an Error
                callback(error.message, null);
            }
        });
}
let axiosSource = [];
let cancelToken = null;
async function GetObject(route, callback, thread)
{
    axios.create({
        baseURL: process.env.APP_URL
    });
    try {
        if (thread) {
            if (axiosSource[thread] !== undefined) {
                axiosSource[thread].cancel("Cancel");
            }
            axiosSource[thread] = axios.CancelToken.source();
            cancelToken = axiosSource[thread].token;
        }
        return await axios.get('/api/' + route,{
            cancelToken: cancelToken,
        })
        //{headers: { Authorization: "Bearer " + token }}
            .then(async function (response) {
                if (callback) {
                    return await callback(null, response.data);
                }
                return await response.data;
            })
            .catch(async function (error) {
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    if (callback) {
                        return await callback(error.response, null);
                    }
                }
                return await error;
            })
    } catch (e) {
        return e;
    }
}

function DeleteObjectApi(route, parameters, callback)
{
    axios.create({
        baseURL: process.env.APP_URL
    });
    axios.delete('/api/' + route, parameters)
        .then(function (response) {
            callback(null, response.data);
        })
        .catch(function (error) {
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                callback(error.response, null);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                callback(error.request, null);
            } else {
                // Something happened in setting up the request that triggered an Error
                callback(error.message, null);
            }
        });
}

export {UpdateObject, UpdateObjectApi, GetObject, DeleteObjectApi};
