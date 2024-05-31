<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h1 class="text-center">Are you sure?</h1>
                <p class="text-center">Once you delete, You can not recover this data and related files.</p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer flex justify-content-center">
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form class="d-inline" action="#" method="post" id="modal-delete-form">
                        @csrf
                        <button type="submit" class="btn btn-danger"  data-bs-dismiss="modal">Delete</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
