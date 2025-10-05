<x-guest-layout>
  <div class="form-container-wide">
    <h2 class="form-title">Create Account</h2>
    <div class="accent-line"></div>
    <p class="form-subtitle">Join the Good Moral Application Portal</p>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <div>
          <!-- First Name -->
          <div style="margin-bottom: 20px;">
            <label for="fname" class="form-label">First Name <span style="color: #dc3545; font-weight: bold;">*</span></label>
            <input id="fname" class="form-input" type="text" name="fname" value="{{ old('fname') }}"
                   required autofocus autocomplete="fname" placeholder="Enter First Name"
                   style="text-transform: uppercase;" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
            <x-input-error :messages="$errors->get('fname')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>

          <!-- Middle Name -->
          <div style="margin-bottom: 20px;">
            <label for="mname" class="form-label">Middle Initial</label>
            <input id="mname" class="form-input" type="text" name="mname" value="{{ old('mname') }}"
                   autocomplete="mname" placeholder="Enter Middle Initial"
                   style="text-transform: uppercase;" pattern="[A-Za-z\s]*" title="Only letters and spaces are allowed">
            <x-input-error :messages="$errors->get('mname')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>

          <!-- Department -->
          <div style="margin-bottom: 20px;">
            <label for="department" class="form-label">Department <span style="color: #dc3545; font-weight: bold;">*</span></label>
            <select id="department" name="department" class="form-input" required>
              <option value="" disabled selected>Select Department</option>
              <option value="SITE">SITE</option>
              <option value="SBAHM">SBAHM</option>
              <option value="SASTE">SASTE</option>
              <option value="SNAHS">SNAHS</option>
              <option value="SOM">SOM</option>
              <option value="GRADSCH">GRADSCH</option>
            </select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>

          <!-- Course (This will be shown/hidden based on account type) -->
          <div id="course-dropdown-main" style="margin-bottom: 20px; display: none; border: 2px solid #e8f5e8; padding: 12px; border-radius: 8px; background: #f8fff8;">
            <label for="year_level_main" class="form-label" style="color: var(--primary-green); font-weight: 600;">Course & Year Level (Required for Students)</label>
            <select id="year_level_main" name="year_level" class="form-input">
              <option value="" disabled selected>Select Course & Year</option>
            </select>
            <x-input-error :messages="$errors->get('year_level')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
            <p style="color: #6b7280; font-size: 12px; margin-top: 4px;">
              Select your department first to see available courses.
            </p>
          </div>

          <!-- Account Type -->
          <div style="margin-bottom: 20px;">
            <label for="account_type" class="form-label">Account Type <span style="color: #dc3545; font-weight: bold;">*</span></label>
            <select id="account_type" name="account_type" class="form-input" required onchange="toggleAccountTypeFields()">
              <option value="" disabled selected>Select Account Type</option>
              <option value="student">Student</option>
              <option value="alumni">Alumni</option>
              <option value="psg_officer">PSG Officer</option>
            </select>
            <x-input-error :messages="$errors->get('account_type')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
            <p style="color: #6c757d; font-size: 12px; margin-top: 8px;">
              <strong>Note:</strong> Students can now register if they don't have an account in the system. Alumni and PSG officers can also create accounts.
            </p>
          </div>

          <!-- PSG Officer Fields (Hidden by default) -->
          <div id="psg-fields" style="display: none;">
            <!-- Organization -->
            <div style="margin-bottom: 20px;">
              <label for="organization" class="form-label">Organization</label>
              <input id="organization" class="form-input" type="text" name="organization" value="{{ old('organization') }}"
                     autocomplete="organization" placeholder="Enter Organization Name"
                     style="text-transform: uppercase;">
              <x-input-error :messages="$errors->get('organization')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
            </div>

            <!-- Position -->
            <div style="margin-bottom: 20px;">
              <label for="position" class="form-label">Position</label>
              <input id="position" class="form-input" type="text" name="position" value="{{ old('position') }}"
                     autocomplete="position" placeholder="Enter Position/Role"
                     style="text-transform: uppercase;">
              <x-input-error :messages="$errors->get('position')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
            </div>
          </div>

          <!-- Student Fields (Hidden by default) -->
          <div id="student-fields" style="display: none;">
            <p style="color: #6c757d; font-size: 12px; margin-bottom: 8px;">
              <strong>Note:</strong> Course selection will appear above after selecting your department.
            </p>

          </div>

        </div>
        <div>
          <!-- Last Name -->
          <div style="margin-bottom: 20px;">
            <label for="lname" class="form-label">Last Name <span style="color: #dc3545; font-weight: bold;">*</span></label>
            <input id="lname" class="form-input" type="text" name="lname" value="{{ old('lname') }}"
                   required autocomplete="lname" placeholder="Enter Last Name"
                   style="text-transform: uppercase;" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
            <x-input-error :messages="$errors->get('lname')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>

          <!-- Extension -->
          <div style="margin-bottom: 20px;">
            <label for="extension" class="form-label">Extension</label>
            <input id="extension" class="form-input" type="text" name="extension" value="{{ old('extension') }}"
                   autocomplete="extension" placeholder="Jr., Sr., III, etc."
                   style="text-transform: uppercase;" pattern="[A-Za-z\s]*" title="Only letters and spaces are allowed">
            <x-input-error :messages="$errors->get('extension')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>

          <!-- Gender -->
          <div style="margin-bottom: 20px;">
            <label for="gender" class="form-label">Gender <span style="color: #dc3545; font-weight: bold;">*</span></label>
            <select id="gender" name="gender" class="form-input" required>
              <option value="" disabled selected>Select Gender</option>
              <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>
          <!-- Student ID -->
          <div style="margin-bottom: 20px;">
            <label for="student_id" class="form-label">Student ID <span style="color: #dc3545; font-weight: bold;">*</span></label>
            <input id="student_id" class="form-input" type="text" name="student_id" value="{{ old('student_id') }}"
                   required autocomplete="student_id" placeholder="Enter Student ID">
            <x-input-error :messages="$errors->get('student_id')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>

          <!-- Email Address -->
          <div style="margin-bottom: 20px;">
            <label for="email" class="form-label">Email Address <span style="color: #dc3545; font-weight: bold;">*</span></label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}"
                   required autocomplete="username" placeholder="Enter Email Address">
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
          </div>
      </div>
    </div>

      <!-- Password Fields (Full Width) -->
      <div style="grid-column: 1 / -1; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 20px;">
        <!-- Password -->
        <div>
          <label for="password" class="form-label">Password <span style="color: #dc3545; font-weight: bold;">*</span></label>
          <input id="password" class="form-input" type="password" name="password"
                 required autocomplete="new-password" placeholder="Enter Password">
          <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="form-label">Confirm Password <span style="color: #dc3545; font-weight: bold;">*</span></label>
          <input id="password_confirmation" class="form-input" type="password" name="password_confirmation"
                 required autocomplete="new-password" placeholder="Confirm Password">
          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: #e74c3c; font-size: 12px;" />
        </div>
      </div>

      <!-- Submit Button -->
      <div style="margin-top: 32px; position: relative; z-index: 100;">
        <!-- Submit Button -->
        <button type="submit" id="submitButton" class="form-button">
          Create Account
        </button>

        <!-- Links -->
        <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid #e1e8ed;">
          <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 8px;">Already have an account?</p>
          <a href="{{ route('login') }}" class="form-link">Sign in here</a>
        </div>
      </div>
    </form>

    <!-- JavaScript for dynamic course dropdown and PSG fields -->
    <script>
      const coursesByDepartment = @json($coursesByDepartment);
      console.log('Courses by department data:', coursesByDepartment);
      console.log('Total departments:', Object.keys(coursesByDepartment).length);

      // Function to toggle account type specific fields
      function toggleAccountTypeFields() {
        const accountType = document.getElementById('account_type').value;
        const psgFields = document.getElementById('psg-fields');
        const studentFields = document.getElementById('student-fields');
        const courseDropdown = document.getElementById('course-dropdown-main');
        const organizationInput = document.getElementById('organization');
        const positionInput = document.getElementById('position');
        const yearLevelInput = document.getElementById('year_level_main');

        console.log('Account type changed to:', accountType);

        // Reset all fields
        psgFields.style.display = 'none';
        studentFields.style.display = 'none';
        courseDropdown.style.display = 'none';

        // Clear requirements
        organizationInput.required = false;
        positionInput.required = false;
        yearLevelInput.required = false;

        // Clear values
        organizationInput.value = '';
        positionInput.value = '';
        yearLevelInput.value = '';

        if (accountType === 'psg_officer') {
          psgFields.style.display = 'block';
          organizationInput.required = true;
          positionInput.required = true;
        } else if (accountType === 'student') {
          console.log('Student account type selected');
          studentFields.style.display = 'block';
          yearLevelInput.required = true;

          // Show course dropdown if department is already selected
          const department = document.getElementById('department').value;
          console.log('Current department:', department);

          courseDropdown.style.display = 'block';
          console.log('Course dropdown should now be visible');

          if (department && coursesByDepartment[department]) {
            console.log('Updating course options for department:', department);
            updateCourseOptions(department);
          } else {
            // Show course dropdown but with placeholder if no department selected
            const courseSelect = document.getElementById('year_level_main');
            courseSelect.innerHTML = '<option value="" disabled selected>Select Department First</option>';
            console.log('Set placeholder for course dropdown');
          }
        }
      }

      // Function to update course options based on department
      function updateCourseOptions(department) {
        const courseSelect = document.getElementById('year_level_main');

        // Clear existing options
        courseSelect.innerHTML = '<option value="" disabled selected>Select Course & Year</option>';

        if (coursesByDepartment[department]) {
          coursesByDepartment[department].forEach(course => {
            // Add year levels for each course
            const years = ['1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year'];
            years.forEach(year => {
              const option = document.createElement('option');
              option.value = `${course} - ${year}`;
              option.textContent = `${course} - ${year}`;
              courseSelect.appendChild(option);
            });
          });
        }
      }

      // Department change handler
      document.getElementById('department').addEventListener('change', function() {
        const department = this.value;
        const accountType = document.getElementById('account_type').value;
        const courseDropdown = document.getElementById('course-dropdown-main');

        console.log('Department changed:', department, 'Account type:', accountType);

        if (accountType === 'student') {
          courseDropdown.style.display = 'block';
          if (department && coursesByDepartment[department]) {
            updateCourseOptions(department);
          } else {
            // Clear options if no valid department
            const courseSelect = document.getElementById('year_level_main');
            courseSelect.innerHTML = '<option value="" disabled selected>Select Department First</option>';
          }
        } else {
          courseDropdown.style.display = 'none';
        }
      });

      // Initialize account type fields on page load
      document.addEventListener('DOMContentLoaded', function() {
        // Check if all elements are found
        const courseDropdown = document.getElementById('course-dropdown-main');
        const yearLevelSelect = document.getElementById('year_level_main');
        console.log('Course dropdown element found:', courseDropdown);
        console.log('Year level select found:', yearLevelSelect);

        toggleAccountTypeFields();

        // Simplified form validation
        const form = document.querySelector('form');
        const submitButton = document.getElementById('submitButton');

        if (form && submitButton) {
          console.log('Form and submit button found successfully');

          // Add click event listener to submit button
          submitButton.addEventListener('click', function(e) {
            console.log('Submit button clicked!');
          });

          // Add form submit event listener with basic validation
          form.addEventListener('submit', function(e) {
            console.log('Form submission started');

            // Basic validation for conditional fields
            const accountType = document.getElementById('account_type').value;

            if (accountType === 'student') {
              const yearLevel = document.getElementById('year_level_main').value;
              const department = document.getElementById('department').value;

              if (!department) {
                alert('Please select your department first.');
                e.preventDefault();
                return false;
              }

              if (!yearLevel) {
                alert('Please select your course and year level.');
                e.preventDefault();
                return false;
              }
            }

            if (accountType === 'psg_officer') {
              const organization = document.getElementById('organization').value;
              const position = document.getElementById('position').value;

              if (!organization || !position) {
                alert('Please fill in your organization and position.');
                e.preventDefault();
                return false;
              }
            }

            console.log('Form validation passed, submitting...');
          });
        } else {
          console.error('Form or submit button not found');
        }
      });
    </script>

    <!-- Ensure button is clickable -->
    <style>
      #submitButton {
        position: relative !important;
        z-index: 999 !important;
        pointer-events: auto !important;
        cursor: pointer !important;
        display: block !important;
        border: 2px solid transparent !important;
      }

      /* Debug: Add a visible border when hovering to confirm button is responsive */
      #submitButton:hover {
        border: 2px solid #fff !important;
        transform: translateY(-1px) !important;
      }

      /* Ensure no elements are blocking the button */
      .form-container-wide * {
        pointer-events: auto;
      }
    </style>
  </div>
</x-guest-layout>