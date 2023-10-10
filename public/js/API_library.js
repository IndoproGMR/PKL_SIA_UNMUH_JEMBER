export default class API_library{
    // public responsAPI;
    constructor(URL) {
        this.URL = URL;
        this.fullURL = URL;
    this.responsAPI;

    }

    setQuery(Query) {
        this.fullURL = this.URL + Query;
    }

    setRespon(data) {
        console.log(data)
        this.responsAPI = data;
        console.log(this.responsAPI)
    }

    runFetch() {
        // let runFetchP = new Promise((resolve, reject) => {
        return new Promise((resolve, reject) => {
            fetch(this.fullURL)
            .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    resolve(data);
                })
                .catch((error) => {
                reject(error);
            });
        });
    }


    getURL() {
        return this.fullURL;
    }

    getRespond() {
        return this.runFetch().then(
            function (value) { return value }
        );
    }

    getError() {
        return this.runFetch()
            .then(() => { },
            function (error) { return error }
            )
    }
}