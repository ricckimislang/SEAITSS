<div class="modal fade" id="updateDepartment" tabindex="-1" role="dialog" aria-labelledby="updateDepartmentLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDepartmentLabel">Update Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateDepartmentForm">
                    <div class="form-group">
                        <label for="department_name">Department Name</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                        <input type="hidden" class="form-control" id="department_id" name="department_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="updateDepartmentBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>