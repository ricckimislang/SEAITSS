<div class="modal fade" id="updateDepartment" tabindex="-1" role="dialog" aria-labelledby="updateDepartmentLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDepartmentLabel">Update Department</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: red;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateDepartmentForm">
                    <div class="form-group">
                        <label for="department_update_name">Select Department</label>
                        <?php
                        $query1 = "SELECT * FROM department";
                        $result1 = mysqli_query($conn, $query1);
                        ?>
                        <select class="form-control" id="department_update_name" name="department_update_name" required>
                            <?php
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                echo "<option value='" . $row1['office_name'] . "'>" . $row1['office_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="department_update_id" name="department_update_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" id="updateDepartmentBtn">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>