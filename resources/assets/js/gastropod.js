var deleteRecordModal = null;
var recordToDeleteForm;
$(document).ready(function() {
    deleteRecordModal = new bootstrap.Modal(document.getElementById('delete-record-modal'));
});

function openDeleteRecordModal(recordId) {
    recordToDeleteForm = `actions-form-item-${recordId}`;
    deleteRecordModal.show();
}

function doDeleteRecord() {
    let formId = recordToDeleteForm;
    recordToDeleteForm = null;
    $(`#${formId}`).submit();
}