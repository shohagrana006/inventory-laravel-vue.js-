class Notification {
    create(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully done !!',
            timeout: 1000,
        }).show();
    }
    alert(){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'are you sure ?',
            timeout: 1000,
        }).show();
    }
    error(){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Something went wrong !!',
            timeout: 1000,
        }).show();
    }
    warning(){
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Its a warning !!',
            timeout: 1000,
        }).show();
    }
    img_validation(){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Uploaded file size should have less than 1MB !!',
            timeout: 2000,
        }).show();
    }
    cart_success(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Add !!',
            timeout: 1000,
        }).show();
    }
    cart_delete(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Delete Successfully !!',
            timeout: 1000,
        }).show();
    }
}

export default Notification = new Notification();