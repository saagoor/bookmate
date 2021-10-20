document.addEventListener('alpine:init', () => {
    Alpine.data("bookPriceFetcher", () => ({
        loading: false,
        loaded: false,
        trigger: {
            ["x-on:optionSelected"]() {
                let book = this.$event.detail;
                this.$dispatch('bookSelected', book);
                this.getPrice(book.id);
            },
        },
        getPrice(bookId) {
            this.loading = true;
            axios
                .post(`/books/${bookId}/price`)
                .then((response) => {
                    this.$refs.price.innerText = response.data;
                    this.loading = false;
                    this.loaded = true;
                })
                .catch((error) => {
                    alert(error.message);
                    this.loading = false;
                });
        },
    }));
})