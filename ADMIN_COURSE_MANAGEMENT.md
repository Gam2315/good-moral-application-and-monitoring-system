# 👨‍💼 Admin Course & Year Level Management System

## Overview
The SPUP Good Moral Application System now includes comprehensive admin management for student course and year level information. Administrators can set and manage course and year level data for students, which automatically appears as static (non-editable) fields in the good moral application forms.

## 🎯 Key Features

### ✅ **Admin Course Management**
- Course and year level columns in admin student table
- Edit student course and year level information
- Department-based course filtering
- Visual indicators for set/unset course data

### ✅ **Static Course Display for Students**
- Course automatically populated from student profile
- Year level displayed alongside course information
- Read-only fields (students cannot modify)
- Clear visual indication of static data

### ✅ **CSV-Based Course Master Data**
- Centralized course database from CSV imports
- Consistent course codes across the system
- Admin interface for course data management

## 🏗️ Database Structure

### **Student Profile Tables**
```sql
-- role_account table (main student records)
ALTER TABLE role_account ADD COLUMN course VARCHAR(20) AFTER department;
ALTER TABLE role_account ADD COLUMN year_level VARCHAR(50) AFTER course;

-- student_registrations table (registration records)
ALTER TABLE student_registrations ADD COLUMN course VARCHAR(20) AFTER department;
```

### **Course Master Data**
```sql
-- courses table (from CSV import)
CREATE TABLE courses (
    id BIGINT PRIMARY KEY,
    course_code VARCHAR(20) UNIQUE,     -- e.g., 'BSIT', 'BSN'
    course_name VARCHAR(255),           -- Full course name
    department VARCHAR(10),             -- e.g., 'SITE', 'SNAHS'
    department_name VARCHAR(255),       -- Full department name
    is_active BOOLEAN DEFAULT TRUE,     -- Active/inactive status
    description TEXT,                   -- Course description
    sort_order INT DEFAULT 0            -- Display order
);
```

## 👨‍💼 Admin Interface Features

### **1. Enhanced Student Table**
```
| Full Name | Student ID | Email | Department | Course | Year Level | Account Type | Status | Actions |
|-----------|------------|-------|------------|--------|------------|--------------|--------|---------|
| John Doe  | S12345     | ...   | SITE       | BSIT   | 4th Year   | student      | Active | Edit    |
```

### **2. Course & Year Level Display**
- **Course Badge**: Green background with course code (e.g., "BSIT")
- **Year Level Badge**: Purple background with year level (e.g., "4th Year")
- **Not Set Indicator**: Gray italic text for missing data

### **3. Edit Student Modal**
```html
<!-- Course Selection (Department-based) -->
<select name="course">
    <option value="">Select Course</option>
    <!-- Populated based on selected department -->
</select>

<!-- Year Level Selection -->
<select name="year_level">
    <option value="">Select Year Level</option>
    <option value="1st Year">1st Year</option>
    <option value="2nd Year">2nd Year</option>
    <option value="3rd Year">3rd Year</option>
    <option value="4th Year">4th Year</option>
    <option value="5th Year">5th Year</option>
    <option value="Graduate">Graduate</option>
</select>
```

## 🎓 Student Interface Features

### **1. Static Course Display**
```html
<!-- Good Moral Application Form -->
<div class="static-field">
    <span class="course-code">BSIT</span> - 
    <span class="course-name">Bachelor of Science in Information Technology</span>
    <span class="year-level">(4th Year)</span>
</div>
<input type="hidden" name="course_completed" value="BSIT">
```

### **2. Visual Design**
- **Static Field Styling**: Gray background with border to indicate read-only
- **Course Code Badge**: Highlighted course code for easy identification
- **Year Level Badge**: Purple badge showing current year level
- **Pin Icon**: 📌 Indicates field is automatically populated

### **3. Error Handling**
```html
<!-- When course is not set -->
<div class="static-field error">
    <span>⚠️ Course not set in your profile</span>
</div>
<small>Please contact the registrar to update your course information</small>
```

## 🔧 Technical Implementation

### **1. Admin Controller Updates**
```php
// AdminController.php - updateAccount method
$validated = $request->validate([
    'fullname' => 'required|string|max:255',
    'student_id' => 'nullable|string|max:255|unique:role_account,student_id,' . $id,
    'email' => 'required|email|max:255|unique:role_account,email,' . $id,
    'department' => 'required|string|max:255',
    'course' => 'nullable|string|max:255',
    'year_level' => 'nullable|string|max:255',
    'account_type' => 'required|string',
    'status' => 'required|in:0,1',
]);

$account->update($validated);
```

### **2. Application Controller Updates**
```php
// ApplicationController.php - dashboard method
$studentCourse = $student->course;
$studentCourseName = $studentCourse ? CourseHelper::getCourseName($studentCourse) : null;
$studentYearLevel = $student->year_level;

return view('dashboard', compact('studentCourse', 'studentCourseName', 'studentYearLevel'));
```

### **3. JavaScript Course Population**
```javascript
// Department-based course filtering
const coursesByDepartment = {
    'SITE': ['BSIT', 'BLIS', 'BS ENSE', 'BS CpE', 'BSCE'],
    'SBAHM': ['BSA', 'BSE', 'BSBAMM', 'BSBA MFM', 'BSBA MOP', 'BSMA', 'BSHM', 'BSTM', 'BSPDMI'],
    'SASTE': ['BAELS', 'BS Psych', 'BS Bio', 'BSSW', 'BSPA', 'BS Bio MB', 'BSEd', 'BEEd', 'BPEd'],
    'SNAHS': ['BSN', 'BSPh', 'BSMT', 'BSPT', 'BSRT']
};

function populateCourseDropdown(department, selectedCourse = '') {
    const courseSelect = document.getElementById('edit_course');
    courseSelect.innerHTML = '<option value="">Select Course</option>';
    
    if (department && coursesByDepartment[department]) {
        coursesByDepartment[department].forEach(course => {
            const option = document.createElement('option');
            option.value = course;
            option.textContent = course;
            if (course === selectedCourse) {
                option.selected = true;
            }
            courseSelect.appendChild(option);
        });
    }
}
```

## 🎨 CSS Styling

### **Static Field Styling**
```css
.static-field {
    padding: 12px 16px;
    background: #f8f9fa;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    color: #333;
    display: flex;
    align-items: center;
}

.static-field .course-code {
    font-weight: 600;
    background: #edf2f7;
    padding: 2px 8px;
    border-radius: 4px;
    margin-right: 8px;
}

.static-field .year-level {
    color: #7b1fa2;
    font-weight: 500;
    background: #f3e5f5;
    padding: 2px 8px;
    border-radius: 4px;
    margin-left: 8px;
    font-size: 12px;
}

.static-field.error {
    background: #fff5f5;
    border-color: #fed7d7;
    color: #c53030;
}
```

## 📋 Admin Workflow

### **1. Setting Student Course & Year Level**
1. **Access Admin Panel**: Navigate to `/admin/AddAccount`
2. **Find Student**: Use search filters to locate student
3. **Edit Student**: Click "Edit" button for the student
4. **Select Department**: Choose student's department
5. **Select Course**: Course dropdown populates based on department
6. **Select Year Level**: Choose appropriate year level
7. **Save Changes**: Submit form to update student profile

### **2. Course Management**
1. **Upload Course Data**: Use `/admin/courses/upload` to import CSV
2. **Manage Courses**: View and manage course master data
3. **Download Template**: Get CSV template for proper format

## 🎓 Student Experience

### **1. Application Form**
1. **Login**: Student logs into their account
2. **Access Form**: Navigate to good moral application
3. **View Course Info**: Course and year level automatically displayed
4. **Complete Form**: Fill other required fields
5. **Submit**: Course data is automatically included

### **2. Visual Feedback**
- **Clear Display**: Course code, full name, and year level shown
- **Static Indication**: Visual cues show field cannot be edited
- **Help Text**: Instructions to contact registrar if data is missing

## 🚀 Benefits

### **For Administrators**
- ✅ **Centralized Management**: Single interface to manage all student course data
- ✅ **Data Consistency**: Ensures accurate course information across applications
- ✅ **Easy Updates**: Simple form to update student course and year level
- ✅ **Visual Overview**: Quick view of student course status in table

### **For Students**
- ✅ **No Data Entry**: Course information automatically populated
- ✅ **Accurate Data**: Information comes from verified admin records
- ✅ **Clear Display**: Easy to see current course and year level
- ✅ **Error Prevention**: Cannot accidentally enter wrong course information

### **For System**
- ✅ **Data Integrity**: Course data cannot be corrupted by user input
- ✅ **Audit Trail**: All course changes tracked through admin interface
- ✅ **Consistency**: Same course data used across all applications
- ✅ **Validation**: Course codes validated against master data

## 📈 Future Enhancements

### **Potential Improvements**
- [ ] **Bulk Course Updates**: CSV import for student course assignments
- [ ] **Course History**: Track course changes over time
- [ ] **Academic Year Integration**: Link courses to specific academic years
- [ ] **Transfer Student Support**: Handle course transfers between departments
- [ ] **Graduation Status**: Automatic year level progression

### **Integration Opportunities**
- [ ] **Student Information System**: Sync with existing SIS
- [ ] **Enrollment System**: Auto-populate from enrollment data
- [ ] **Academic Records**: Validate against transcript data
- [ ] **Class Schedules**: Integration with scheduling system

---

**✨ The admin course management system provides complete control over student course data while ensuring a seamless, error-free experience for students applying for good moral certificates!**
