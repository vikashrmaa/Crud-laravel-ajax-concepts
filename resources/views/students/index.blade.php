<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel AJAX CRUD</title>

    <!-- Load jQuery (JavaScript Library) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Load SweetAlert2 (For Better Alert Messages) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h2>Student Management</h2>

    <!-- Add/Edit Student Form -->
    <form id="studentForm">
        <input type="hidden" id="student_id">  <!-- Stores ID when editing -->
        <input type="text" id="name" placeholder="Name" required>  <!-- Name input -->
        <input type="email" id="email" placeholder="Email" required>  <!-- Email input -->
        <button type="submit">Save</button>  <!-- Submit button -->
    </form>

    <script>
        $(document).ready(function () {
            // When the form is submitted
            $('#studentForm').submit(function (e) {
                e.preventDefault();  // Prevent page reload
                
                let id = $('#student_id').val();  // Get student ID (if editing)
                let name = $('#name').val();  // Get entered name
                let email = $('#email').val();  // Get entered email

                let url = id ? `/students/${id}` : '/students';  // If ID exists, update student
                let method = id ? 'PUT' : 'POST';  // Use PUT for update, POST for new student

                // AJAX Request to Laravel Backend
                $.ajax({
                    url: url,
                    type: method,
                    data: { name, email, _token: '{{ csrf_token() }}' },  // Send CSRF token
                    success: function () {
                        $('#student_id').val('');  // Clear hidden ID field
                        $('#name').val('');  // Clear name field
                        $('#email').val('');  // Clear email field
                        alert('Student record updated in database (Check phpMyAdmin)');
                    }
                });
            });

            // Function to Edit a Student
            window.editStudent = function (id) {
                $.get(`/students/${id}/edit`, function (response) {
                    $('#student_id').val(response.student.id);  // Fill ID field
                    $('#name').val(response.student.name);  // Fill name field
                    $('#email').val(response.student.email);  // Fill email field
                });
            };

            // Function to Delete a Student
            window.deleteStudent = function (id) {
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: `/students/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function () {
                            alert('Student deleted from database (Check phpMyAdmin)');
                        }
                    });
                }
            };
        });
    </script>
</body>
</html>
