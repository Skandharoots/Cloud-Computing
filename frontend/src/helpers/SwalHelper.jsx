import Swal from 'sweetalert2';

class SwalHelper
{
    static DisplaySuccessPopup(text = 'Operation was successful!', afterCallback = () => {}) {
        Swal.fire({
            title: 'Success!',
            text: text,
            icon: 'success',
        }).then(() => {
            afterCallback();
        })
    }

    static DisplayQuestionPopup(text = 'Do you want to continue?', afterCallback = () => {}) {
        Swal.fire({
            title: 'Question!',
            text: text,
            icon: 'question',
            confirmButtonText: 'Yes',
            showDenyButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                afterCallback();
            }
        })
    }

    static DisplayDangerousQuestionPopup(text = 'You are about to make an important decision. Do you want to continue?', afterCallback = () => {}) {
        Swal.fire({
            title: 'Question!',
            text: text,
            icon: 'warning',
            confirmButtonText: 'No',
            denyButtonText: 'Yes',
            showDenyButton: true,
        }).then((result) => {
            if (result.isDenied) {
                afterCallback();
            }
        })
    }

    static DisplayInfoPopup(text, afterCallback = () => {}) {
        Swal.fire({
            title: 'Information',
            text: text,
            icon: 'info',
        }).then(() => {
            afterCallback();
        })
    }

    static DisplayWarningPopup(text, afterCallback = () => {}) {
        Swal.fire({
            title: 'Warning!',
            text: text,
            icon: 'warning',
        }).then(() => {
            afterCallback();
        })
    }

    static DisplayErrorPopup(text = 'Oh no, something went wrong!', afterCallback = () => {}) {
        Swal.fire({
            title: 'Error!',
            text: text,
            icon: 'error',
        }).then(() => {
            afterCallback();
        })
    }

    static DisplayInputPopup(title, afterCallback = () => {}) {
        Swal.fire({
            title: title,
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                afterCallback(result.value);
            }
        })
    }
}

export default SwalHelper;