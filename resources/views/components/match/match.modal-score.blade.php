<div
    x-data="{
        openScoreModal: false,
        showToast: false,

        closeModal() {
            this.openScoreModal = false;

            this.showToast = true;

            setTimeout(() => {
                this.showToast = false
            }, 3000)
        }
    }"

    x-on:score-updated.window="closeModal()">
</div>
