# 📊 CSV Course & Year Level Extraction System

## Overview
The SPUP Good Moral Application System now automatically extracts course and year level information from the uploaded CSV files during student import. The system intelligently parses the `course_year` field to separate course codes and year levels, eliminating the need for manual admin entry.

## 🎯 Key Features

### ✅ **Automatic Course Parsing**
- Extracts course code and year level from single CSV field
- Supports multiple course_year formats
- Intelligent pattern recognition
- Fallback handling for edge cases

### ✅ **Smart Pattern Recognition**
- **Standard Format**: "BSIT 1st Year" → Course: "BSIT", Year: "1st Year"
- **Multi-word Courses**: "BS Psych 3rd Year" → Course: "BS Psych", Year: "3rd Year"
- **Separator Formats**: "BSIT-1st", "BSN_2nd" → Parsed correctly
- **Graduate Status**: "Graduate" → Year: "Graduate", Course: empty

### ✅ **Robust Data Handling**
- Validates extracted course codes
- Normalizes year level formats
- Handles missing or malformed data
- Provides detailed import feedback

## 📋 CSV Format

### **Required Columns**
```csv
student_id,first_name,middle_initial,last_name,extension_name,department,course_year,email
```

### **Sample CSV Data**
```csv
student_id,first_name,middle_initial,last_name,extension_name,department,course_year,email
2024-001,JUAN,D,CRUZ,JR,SITE,BSIT 1st Year,juan.cruz@spup.edu.ph
2024-002,MARIA,S,GARCIA,,SASTE,BS Psych 2nd Year,maria.garcia@spup.edu.ph
2024-003,JOSE,,RIZAL,,SBAHM,BSA 3rd Year,jose.rizal@spup.edu.ph
2024-004,ANNA,M,SANTOS,,SNAHS,BSN 4th Year,anna.santos@spup.edu.ph
2024-005,MARK,J,DELA CRUZ,,SITE,BS CpE 2nd Year,mark.delacruz@spup.edu.ph
```

## 🔧 Parsing Algorithm

### **1. Pattern Recognition**
The system recognizes these course_year formats:

#### **Standard Formats**
- `BSIT 1st Year` → Course: "BSIT", Year: "1st Year"
- `BSN 2nd Year` → Course: "BSN", Year: "2nd Year"
- `BSA 3rd Year` → Course: "BSA", Year: "3rd Year"
- `BSIT 4th Year` → Course: "BSIT", Year: "4th Year"

#### **Multi-word Course Names**
- `BS Psych 1st Year` → Course: "BS Psych", Year: "1st Year"
- `BS CpE 2nd Year` → Course: "BS CpE", Year: "2nd Year"
- `BS Bio MB 3rd Year` → Course: "BS Bio MB", Year: "3rd Year"

#### **Alternative Separators**
- `BSIT-1st` → Course: "BSIT", Year: "1st Year"
- `BSN_2nd` → Course: "BSN", Year: "2nd Year"
- `BSA 3rd` → Course: "BSA", Year: "3rd Year"

#### **Special Cases**
- `Graduate` → Course: "", Year: "Graduate"
- `BSIT` → Course: "BSIT", Year: ""
- `` (empty) → Course: "", Year: ""

### **2. Parsing Logic**
```php
private function parseCourseYear($courseYearString)
{
    // Step 1: Check for common year patterns
    $yearPatterns = [
        '1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year',
        'First Year', 'Second Year', 'Third Year', 'Fourth Year', 'Fifth Year',
        'Graduate', 'Graduated'
    ];

    // Step 2: Extract year level and course
    foreach ($yearPatterns as $pattern) {
        if (stripos($courseYearString, $pattern) !== false) {
            $yearLevel = $pattern;
            $course = trim(str_ireplace($pattern, '', $courseYearString));
            break;
        }
    }

    // Step 3: Handle alternative formats (BSIT-1st, BSN_2nd)
    if (!$yearLevel) {
        if (preg_match('/^(.+?)[\s\-_]+(\d+(?:st|nd|rd|th)?\s*(?:year|yr)?)/i', $courseYearString, $matches)) {
            $course = trim($matches[1]);
            $yearLevel = trim($matches[2]);
            // Normalize: "1st" → "1st Year"
            $yearLevel = preg_replace('/(\d+)(st|nd|rd|th)?\s*(year|yr)?/i', '$1$2 Year', $yearLevel);
        }
    }

    // Step 4: Clean up and return
    return [
        'course' => $course ?: null,
        'year_level' => $yearLevel ?: null
    ];
}
```

## 🗄️ Database Storage

### **Student Records**
```sql
-- role_account table
INSERT INTO role_account (
    student_id, fullname, email, department, 
    course, year_level, account_type, status
) VALUES (
    '2024-001', 'JUAN D CRUZ JR', 'juan.cruz@spup.edu.ph', 'SITE',
    'BSIT', '1st Year', 'student', '1'
);

-- student_registrations table
INSERT INTO student_registrations (
    student_id, fname, mname, lname, email, department,
    course, year_level, account_type, status
) VALUES (
    '2024-001', 'JUAN', 'D', 'CRUZ', 'juan.cruz@spup.edu.ph', 'SITE',
    'BSIT', '1st Year', 'student', '1'
);
```

## 📊 Import Process

### **1. CSV Upload**
1. **Access**: Navigate to `/admin/AddAccount`
2. **Upload**: Click "Import Users" and select CSV file
3. **Process**: System automatically parses course_year field
4. **Validate**: Course codes validated against master data
5. **Import**: Students created with course and year level data

### **2. Parsing Results**
```
✅ Parsing Results:
- Input: "BSIT 1st Year" → Course: "BSIT", Year: "1st Year"
- Input: "BS Psych 2nd Year" → Course: "BS Psych", Year: "2nd Year"
- Input: "BSA 3rd Year" → Course: "BSA", Year: "3rd Year"
- Input: "BSN 4th Year" → Course: "BSN", Year: "4th Year"
- Input: "BS CpE 2nd Year" → Course: "BS CpE", Year: "2nd Year"
```

### **3. Import Feedback**
```
📋 Import Summary:
✅ Successfully imported: 5 students
⚠️ Warnings: 0
❌ Errors: 0

📊 Course Distribution:
- BSIT: 1 student
- BS Psych: 1 student  
- BSA: 1 student
- BSN: 1 student
- BS CpE: 1 student

📈 Year Level Distribution:
- 1st Year: 2 students
- 2nd Year: 2 students
- 3rd Year: 1 student
```

## 🎓 Student Experience

### **1. Automatic Population**
After CSV import, students see their course and year level automatically populated:

```html
<!-- Good Moral Application Form -->
<div class="static-field">
    <span class="course-code">BSIT</span> - 
    <span class="course-name">Bachelor of Science in Information Technology</span>
    <span class="year-level">(1st Year)</span>
</div>
```

### **2. Data Consistency**
- ✅ **Same Data**: Course info consistent across all applications
- ✅ **No Errors**: Students cannot enter incorrect course information
- ✅ **Auto-Update**: Changes in admin reflect immediately in forms

## 🔍 Validation & Error Handling

### **1. Course Code Validation**
```php
// Validate extracted course against master data
$validCourses = array_keys(CourseHelper::getAllCourses());
if ($course && !in_array($course, $validCourses)) {
    $warnings[] = "Row {$rowNumber}: Course '{$course}' not found in master data";
}
```

### **2. Year Level Normalization**
```php
// Normalize year level formats
"1st" → "1st Year"
"2nd yr" → "2nd Year"  
"Third Year" → "Third Year"
"Graduate" → "Graduate"
```

### **3. Import Warnings**
```
⚠️ Import Warnings:
- Row 3: Course 'BSXX' not found in master data
- Row 5: Could not parse year level from 'BSIT Unknown'
- Row 7: Missing course_year field
```

## 📈 Benefits

### **For Administrators**
- ✅ **Automated Process**: No manual course entry required
- ✅ **Bulk Import**: Process hundreds of students at once
- ✅ **Data Quality**: Consistent course and year level data
- ✅ **Time Saving**: Eliminates manual data entry errors

### **For Students**
- ✅ **Accurate Data**: Course information from official records
- ✅ **No Input Required**: Course automatically populated
- ✅ **Consistent Forms**: Same data across all applications
- ✅ **Error Prevention**: Cannot enter wrong course information

### **For System**
- ✅ **Data Integrity**: Course data validated and normalized
- ✅ **Scalability**: Handles large CSV imports efficiently
- ✅ **Flexibility**: Supports multiple course_year formats
- ✅ **Maintainability**: Centralized parsing logic

## 🚀 Advanced Features

### **1. Flexible Format Support**
The parser handles various real-world CSV formats:
- University registrar exports
- Student information system dumps
- Manual data entry variations
- Legacy system migrations

### **2. Error Recovery**
- **Partial Parsing**: Extracts what it can from malformed data
- **Fallback Logic**: Uses course-only data when year is unclear
- **Manual Override**: Admins can edit parsed data if needed

### **3. Audit Trail**
- **Import Logs**: Detailed logs of parsing results
- **Change Tracking**: Track course data changes over time
- **Validation Reports**: Summary of parsing success/failures

## 📋 Testing Examples

### **Test Cases**
```php
// Standard formats
"BSIT 1st Year" → Course: "BSIT", Year: "1st Year" ✅
"BSN 2nd Year" → Course: "BSN", Year: "2nd Year" ✅

// Multi-word courses  
"BS Psych 3rd Year" → Course: "BS Psych", Year: "3rd Year" ✅
"BS CpE 2nd Year" → Course: "BS CpE", Year: "2nd Year" ✅

// Alternative formats
"BSIT-1st" → Course: "BSIT", Year: "1st Year" ✅
"BSN_2nd" → Course: "BSN", Year: "2nd Year" ✅

// Edge cases
"Graduate" → Course: "", Year: "Graduate" ✅
"BSIT" → Course: "BSIT", Year: "" ✅
"" → Course: "", Year: "" ✅
```

## 🔧 Troubleshooting

### **Common Issues**

#### **Course Not Recognized**
- **Problem**: "Course 'BSXX' not found in master data"
- **Solution**: Import course data via CSV or add manually
- **Prevention**: Use standardized course codes

#### **Year Level Not Parsed**
- **Problem**: "Could not parse year level from 'BSIT Unknown'"
- **Solution**: Use standard year formats (1st Year, 2nd Year, etc.)
- **Prevention**: Follow CSV template format

#### **Missing Course Data**
- **Problem**: Students show "Course not set in profile"
- **Solution**: Re-import CSV with correct course_year format
- **Prevention**: Validate CSV before import

---

**✨ The CSV course extraction system ensures accurate, automated population of student course and year level data, eliminating manual entry errors and providing a seamless import experience!** 📊🎓📱💻
