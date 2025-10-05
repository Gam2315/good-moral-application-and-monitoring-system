@php
  $accountType = Auth::user()->account_type;
  $roleTitle = $accountType === 'alumni' ? 'Alumni' : 'Student';
@endphp

<x-dashboard-layout>
  <x-slot name="roleTitle">{{ $roleTitle }}</x-slot>

  <x-slot name="navigation">
    <a href="{{ route('dashboard') }}"
       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="nav-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <span>Application</span>
    </a>

    <a href="{{ route('notification') }}"
       class="nav-link {{ request()->routeIs('notification') ? 'active' : '' }}" style="position: relative;">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="nav-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span>Application Notifications</span>
      <span class="notification-bell" id="student-notifications-bell" style="display: none; position: absolute; top: 12px; right: 20px; background: #ffc107; padding: 4px 8px; border-radius: 50%; font-size: 12px; font-weight: 700; color: #333; min-width: 20px; height: 20px; text-align: center; line-height: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
        <span id="student-notifications-count">0</span>
      </span>
    </a>

    <a href="{{ route('notificationViolation') }}"
       class="nav-link {{ request()->routeIs('notificationViolation') ? 'active' : '' }}" style="position: relative;">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="nav-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
      </svg>
      <span>Violation Notifications</span>
      <span class="notification-bell" id="student-violations-bell" style="display: none; position: absolute; top: 12px; right: 20px; background: #dc3545; padding: 4px 8px; border-radius: 50%; font-size: 12px; font-weight: 700; color: white; min-width: 20px; height: 20px; text-align: center; line-height: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
        <span id="student-violations-count">0</span>
      </span>
    </a>

    <a href="{{ route('student.profile') }}"
       class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="nav-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      <span>Profile</span>
    </a>

    <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
      @csrf
      <button type="submit" class="nav-link nav-logout">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="nav-icon">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span>Logout</span>
      </button>
    </form>
  </x-slot>

  <!-- Header Section -->
  <div class="header-section">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
      <div style="flex: 1; min-width: 250px;">
        <h1 class="responsive-title role-title">{{ $roleTitle }} Dashboard</h1>
        <p class="responsive-text welcome-text">Welcome back, {{ $fullname }}!</p>
        <div class="accent-line"></div>
      </div>
      <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <div style="padding: 12px 16px; background: var(--light-green); border-radius: 8px; font-size: 14px; color: var(--primary-green); font-weight: 600; white-space: nowrap;">
          {{ date('F j, Y') }}
        </div>
      </div>
    </div>
  </div>

  @if(session('status'))
  <div style="background: #d4edda; color: #155724; padding: 16px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid #28a745;">
    <strong>Success!</strong> {{ session('status') }}
  </div>
  @endif

  <!-- Status Overview -->
  <div class="responsive-container">
    <div class="stats-grid responsive-grid responsive-grid-3" style="width: 100%; margin: 0; gap: 16px; align-items: stretch;">
      <!-- Application Status -->
      <div class="stat-card responsive-card" style="border-top-color: var(--primary-green); flex: 1; height: 100%;">
        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap; justify-content: center;">
          <div style="height: 60px; width: 60px; border-radius: 50%; background: var(--primary-green); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" style="height: 30px; width: 30px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0.621 0 1.125-.504 1.125-1.125V9.375c0-.621.504-1.125 1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
            </svg>
          </div>
          <div style="flex: 1; min-width: 120px;">
            <div class="stat-number">
              @if (count($availableCertificates) > 0)
                Eligible
              @else
                Restricted
              @endif
            </div>
            <div class="stat-label">Application Status</div>
          </div>
        </div>
      </div>

      <!-- Violations Status -->
      <div class="stat-card responsive-card" style="border-top-color: {{ $Violation->isEmpty() ? '#28a745' : '#dc3545' }}; flex: 1; height: 100%;">
        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap; justify-content: center;">
          <div style="height: 60px; width: 60px; border-radius: 50%; background: {{ $Violation->isEmpty() ? '#28a745' : '#dc3545' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" style="height: 30px; width: 30px;">
              @if($Violation->isEmpty())
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              @else
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              @endif
            </svg>
          </div>
          <div style="flex: 1; min-width: 120px;">
            <div class="stat-number">{{ $Violation->count() }}</div>
            <div class="stat-label">Active Violations</div>
          </div>
        </div>
      </div>

      <!-- Account Type -->
      <div class="stat-card responsive-card" style="border-top-color: var(--primary-yellow); flex: 1; height: 100%;">
        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap; justify-content: center;">
          <div style="height: 60px; width: 60px; border-radius: 50%; background: var(--primary-yellow); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#333" style="height: 30px; width: 30px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
          </div>
          <div style="flex: 1; min-width: 120px;">
            <div class="stat-number">{{ ucfirst($accountType) }}</div>
            <div class="stat-label">Account Type</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Application Process Guide -->
  <div class="responsive-container">
    <div class="header-section">
      <h3 class="process-guide-title">Application Process Guide</h3>
      <div class="process-guide-grid">
        <div class="process-guide-card process-flow-card">
          <h4 class="process-guide-card-title">📋 Application Flow</h4>
          <ol class="process-flow-list">
            <li>Submit application</li>
            <li>Registrar review & approval</li>
            <li>Dean review & approval</li>
            <li>Administrator final approval</li>
            <li>Upload Receipt</li>
            <li>Certificate pickup at Office of Student Affairs</li>
          </ol>
        </div>

        <div class="process-guide-card processing-time-card">
          <h4 class="process-guide-card-title">⏱️ Processing Time</h4>
          <p class="process-guide-text">Applications typically take 3-5 business days to process. You will be notified when your certificate is ready for pickup.</p>
        </div>

        <div class="process-guide-card help-card">
          <h4 class="process-guide-card-title">📞 Need Help?</h4>
          <p class="process-guide-text">Contact the Office of Student Affairs for questions about your application status, requirements, or certificate pickup.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Application Form Section -->
  @if (!empty($availableCertificates))
  <div class="responsive-container">
    <div class="header-section">
      <h3 class="responsive-subtitle" style="color: var(--primary-green); margin-bottom: 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 24px; width: 24px; flex-shrink: 0;">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0.621 0 1.125-.504 1.125-1.125V9.375c0-.621.504-1.125 1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
        </svg>
        <span>Apply for Certificate</span>
      </h3>

    <!-- Certificate Type Selection -->
    @if (count($availableCertificates) > 1)
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 24px;">
      <h4 style="color: #333; margin-bottom: 16px; font-size: 1.1rem;">Available Certificate Types</h4>
      <div style="display: grid; gap: 12px;">
        @foreach($availableCertificates as $cert)
        <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e1e5e9;">
          <h5 style="color: var(--primary-green); margin: 0 0 8px 0; font-size: 1rem;">{{ $cert['name'] }}</h5>
          <p style="color: #666; margin: 0; font-size: 14px;">{{ $cert['description'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
    @elseif (count($availableCertificates) === 1)
    <div style="background: #e8f5e8; padding: 16px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid var(--primary-green);">
      <h4 style="color: var(--primary-green); margin: 0 0 8px 0; font-size: 1rem;">{{ $availableCertificates[0]['name'] }}</h4>
      <p style="color: #333; margin: 0; font-size: 14px;">{{ $availableCertificates[0]['description'] }}</p>
      @if (!$Violation->isEmpty())
      <p style="color: #856404; margin: 8px 0 0 0; font-size: 14px; font-weight: 500;">
        <strong>Note:</strong> Due to unresolved violations, you can only apply for a Certificate of Residency at this time.
      </p>
      @endif
    </div>
    @endif

    <form method="POST" action="{{ route('apply.good_moral_certificate') }}" class="responsive-form">
      @csrf

      <!-- Certificate Type Selection -->
      @if (count($availableCertificates) > 1)
      <div class="responsive-form-group">
        <label style="font-weight: 600; color: #333;">Certificate Type</label>
        <div style="display: grid; gap: 12px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
          @foreach($availableCertificates as $cert)
          <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer; padding: 12px; border-radius: 6px; border: 2px solid #e1e5e9; background: white; transition: all 0.2s ease; min-height: 44px;"
                 onmouseover="this.style.borderColor='var(--primary-green)'"
                 onmouseout="this.style.borderColor='#e1e5e9'">
            <input type="radio" name="certificate_type" value="{{ $cert['type'] }}" required
                   style="accent-color: var(--primary-green); transform: scale(1.2); margin-top: 2px; flex-shrink: 0;">
            <div style="flex: 1;">
              <div style="font-weight: 600; color: var(--primary-green); margin-bottom: 4px; font-size: clamp(14px, 2vw, 16px);">{{ $cert['name'] }}</div>
              <div style="font-size: clamp(12px, 1.5vw, 14px); color: #666; line-height: 1.4;">{{ $cert['description'] }}</div>
            </div>
          </label>
          @endforeach
        </div>
        @error('certificate_type')
          <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
        @enderror
      </div>
      @else
      <!-- Hidden input for single certificate type -->
      <input type="hidden" name="certificate_type" value="{{ $availableCertificates[0]['type'] }}">
      @endif

      <!-- Gender (from profile) -->
      <input type="hidden" name="gender" value="{{ Auth::user()->gender ?? 'male' }}">

      <!-- Number of Copies -->
      <div class="responsive-form-group">
        <label for="num_copies" style="font-weight: 600; color: #333;">Number of Copies <span style="color: #dc3545; font-weight: bold;">*</span></label>
        <input id="num_copies" name="num_copies" type="number" min="1" required
               value="{{ old('num_copies') }}" class="responsive-form-input"
               placeholder="Enter number of copies" onchange="updatePaymentAmount()">

        <!-- Payment Information -->
        <div style="background: #e8f5e8; padding: 12px; border-radius: 6px; border-left: 4px solid var(--primary-green); margin-top: 8px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
            <span style="font-weight: 600; color: #333; font-size: 14px;">Payment Required:</span>
            <span style="font-weight: 600; color: var(--primary-green); font-size: 16px;" id="totalAmount">₱50.00</span>
          </div>
          <div style="font-size: 12px; color: #666;">
            <span id="paymentCalculation">1 reason × 1 copy × ₱50.00</span>
          </div>
          <div style="font-size: 12px; color: #666; margin-top: 4px; font-style: italic;">
            💡 Payment receipt upload required after admin approval
          </div>
        </div>

        @error('num_copies')
          <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Reason of Application -->
      <div style="display: grid; gap: 12px;">
        <label style="font-weight: 600; color: #333;">Reason of Application (select all that apply) <span style="color: #dc3545; font-weight: bold;">*</span></label>
        <div style="display: grid; gap: 12px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
          @php
            $reasons = [
              'Transfer',
              'Employment',
              'Scholarship',
              'Board Examination',
              'Government examination',
              'VISA/Passport application',
              'PSG Election',
              'Cross enrollment'
            ];

            // Remove PSG Election for alumni
            if ($accountType === 'alumni') {
              $reasons = array_filter($reasons, function($reason) {
                return $reason !== 'PSG Election';
              });
            }
          @endphp

          @foreach($reasons as $reason)
          <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background-color 0.2s ease;"
                 onmouseover="this.style.backgroundColor='#e9ecef'"
                 onmouseout="this.style.backgroundColor='transparent'">
            <input type="checkbox" name="reason[]" value="{{ $reason }}" class="reason-checkbox"
                   style="accent-color: var(--primary-green); transform: scale(1.2);">
            <span style="font-size: 14px;">{{ $reason }}</span>
          </label>
          @endforeach

          <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 8px; border-radius: 6px; transition: background-color 0.2s ease;"
                 onmouseover="this.style.backgroundColor='#e9ecef'"
                 onmouseout="this.style.backgroundColor='transparent'">
            <input type="checkbox" name="reason[]" value="Others" id="reasonOthers" class="reason-checkbox"
                   style="accent-color: var(--primary-green); transform: scale(1.2);">
            <span style="font-size: 14px;">Others (please specify)</span>
          </label>

          <input type="text" name="reason_other" id="reasonOtherInput"
                 style="padding: 12px 16px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px; margin-top: 8px; transition: border-color 0.3s ease;"
                 placeholder="Please specify..." disabled>
        </div>
        <div id="reasonError" style="color: #dc3545; font-size: 14px; display: none;">Please select at least one reason.</div>
        @error('reason')
          <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
        @enderror
      </div>

      @if ($accountType === 'alumni')
      <!-- Alumni specific fields -->
      <div class="responsive-form-row responsive-grid-2">
        <div class="responsive-form-group">
          <label for="graduation_date" style="font-weight: 600; color: #333;">Date of Graduation <span style="color: #dc3545; font-weight: bold;">*</span></label>
          <input id="graduation_date" name="graduation_date" type="date"
                 value="{{ old('graduation_date') }}" class="responsive-form-input">
          @error('graduation_date')
            <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
          @enderror
        </div>

        <div class="responsive-form-group">
          <label for="course_completed" style="font-weight: 600; color: #333;">Course Completed</label>
          @if($studentCourse && $studentCourseName)
            <div class="static-field">
              <span class="course-code">{{ $studentCourse }}</span> - <span class="course-name">{{ $studentCourseName }}</span>
              @if($studentYearLevel)
                <span class="year-level">({{ $studentYearLevel }})</span>
              @endif
            </div>
            <input type="hidden" name="course_completed" value="{{ $studentCourse }}">
            <small style="color: #666; font-size: 12px; margin-top: 4px; display: block;">
              📌 Course and year level information is automatically populated from your student profile
            </small>
          @else
            <div class="static-field error">
              <span style="color: #dc3545;">⚠️ Course not set in your profile</span>
            </div>
            <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">
              Please contact the registrar to update your course information
            </small>
          @endif
          @error('course_completed')
            <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
          @enderror
        </div>
      </div>
      @elseif ($accountType === 'student')
      <!-- Student specific fields -->
      <div class="responsive-form">
        <div class="responsive-form-group">
          <label for="last_course_year_level" style="font-weight: 600; color: #333;">Course of Last School Attended in SPUP</label>
          @if($studentCourse && $studentCourseName)
            <div class="static-field">
              <span class="course-code">{{ $studentCourse }}</span> - <span class="course-name">{{ $studentCourseName }}</span>
              @if($studentYearLevel)
                <span class="year-level">({{ $studentYearLevel }})</span>
              @endif
            </div>
            <input type="hidden" name="last_course_year_level" value="{{ $studentCourse }}">
            <small style="color: #666; font-size: 12px; margin-top: 4px; display: block;">
              📌 Course and year level information is automatically populated from your student profile
            </small>
          @else
            <div class="static-field error">
              <span style="color: #dc3545;">⚠️ Course not set in your profile</span>
            </div>
            <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">
              Please contact the registrar to update your course information
            </small>
          @endif
          @error('last_course_year_level')
            <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
          @enderror
        </div>

        <div class="responsive-form-group">
          <label for="last_semester_sy" style="font-weight: 600; color: #333;">Semester and School Year of Last Attendance in SPUP <span style="color: #dc3545; font-weight: bold;">*</span></label>
          <select id="last_semester_sy" name="last_semester_sy" class="responsive-form-input" required>
            <option value="" disabled selected>Select semester and school year</option>
            <option value="First Semester of 2023-2024" {{ old('last_semester_sy') == 'First Semester of 2023-2024' ? 'selected' : '' }}>
              First Semester of 2023-2024
            </option>
            <option value="Second Semester of 2023-2024" {{ old('last_semester_sy') == 'Second Semester of 2023-2024' ? 'selected' : '' }}>
              Second Semester of 2023-2024
            </option>
            <option value="Summer Term of 2023-2024" {{ old('last_semester_sy') == 'Summer Term of 2023-2024' ? 'selected' : '' }}>
              Summer Term of 2023-2024
            </option>
            <option value="First Semester of 2024-2025" {{ old('last_semester_sy') == 'First Semester of 2024-2025' ? 'selected' : '' }}>
              First Semester of 2024-2025
            </option>
            <option value="Second Semester of 2024-2025" {{ old('last_semester_sy') == 'Second Semester of 2024-2025' ? 'selected' : '' }}>
              Second Semester of 2024-2025
            </option>
            <option value="Summer Term of 2024-2025" {{ old('last_semester_sy') == 'Summer Term of 2024-2025' ? 'selected' : '' }}>
              Summer Term of 2024-2025
            </option>
          </select>
          @error('last_semester_sy')
            <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
          @enderror
        </div>
      </div>
      @endif

      <!-- Submit Button -->
      <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
        <button type="submit" class="responsive-btn responsive-btn-primary" style="display: flex; align-items: center; gap: 8px; color: white;">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" style="height: 20px; width: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
          </svg>
          <span style="color: #fff;">Submit Application</span>
        </button>
      </div>
    </form>
    </div>
  </div>
  @else
  <div class="header-section">
    <div style="background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; border-left: 4px solid #dc3545; display: flex; align-items: center; gap: 16px;">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 24px; width: 24px; color: #dc3545;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
      </svg>
      <div>
        <strong>No Certificates Available</strong>
        <p style="margin: 4px 0 0 0;">No certificate applications are available at this time. Please contact the Dean's office for assistance.</p>
      </div>
    </div>
  </div>
  @endif

  <!-- Violations Section -->
  <div class="responsive-container">
    <div class="header-section">
      <h3 class="responsive-subtitle" style="color: var(--primary-green); margin-bottom: 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 24px; width: 24px; flex-shrink: 0;">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Violation Status</span>
      </h3>

    @if ($Violation->isEmpty())
    <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745; display: flex; align-items: center; gap: 16px;">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 24px; width: 24px; color: #28a745;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <div>
        <strong>No Violations</strong>
        <p style="margin: 4px 0 0 0;">You have no existing violations. You are eligible to apply for a Good Moral Certificate.</p>
      </div>
    </div>
    @else
    <div style="background: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 20px; display: flex; align-items: center; gap: 16px;">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 24px; width: 24px; color: #dc3545;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
      </svg>
      <div>
        <strong>Active Violations Found</strong>
        <p style="margin: 4px 0 0 0;">You have {{ $Violation->count() }} active violation(s). Please resolve these before applying for a Good Moral Certificate.</p>
      </div>
    </div>

    <!-- Violations Table -->
    <div class="responsive-table-container">
      <table class="responsive-table">
        <thead>
          <tr style="background: var(--dark-green); color: white;">
            <th style="color: white;">Offense Type</th>
            <th style="color: white;">Description</th>
            <th class="desktop-only" style="color: white;">Date Committed</th>
            <th style="color: white;">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($Violation as $index => $violation)
          <tr style="border-bottom: 1px solid #e9ecef; {{ $index % 2 === 0 ? 'background: #f8f9fa;' : 'background: white;' }}">
            <td>
              <span style="background: {{ $violation->offense_type === 'major' ? '#dc3545' : '#ffc107' }}; color: {{ $violation->offense_type === 'major' ? 'white' : '#333' }}; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; white-space: nowrap;">
                {{ ucfirst($violation->offense_type) }}
              </span>
            </td>
            <td>
              <div style="color: #333; line-height: 1.4;">{{ $violation->violation }}</div>
              <div class="mobile-only" style="color: #666; font-size: 12px; margin-top: 4px;">{{ $violation->created_at->format('M d, Y') }}</div>
            </td>
            <td class="desktop-only" style="color: #666;">{{ $violation->created_at->format('M d, Y') }}</td>
            <td>
              <span style="background: #ffc107; color: #333; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                PENDING
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif
    </div>
  </div>

  <!-- JavaScript for form interactions -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const otherCheckbox = document.getElementById('reasonOthers');
      const otherInput = document.getElementById('reasonOtherInput');
      const allCheckboxes = document.querySelectorAll('.reason-checkbox');

      // Handle "Others" checkbox
      allCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          if (otherCheckbox.checked) {
            otherInput.disabled = false;
            otherInput.required = true;
            otherInput.style.borderColor = 'var(--primary-green)';
          } else {
            otherInput.disabled = true;
            otherInput.required = false;
            otherInput.value = '';
            otherInput.style.borderColor = '#e1e5e9';
          }

          // Hide error message when user selects a reason
          const checkedBoxes = document.querySelectorAll('.reason-checkbox:checked');
          if (checkedBoxes.length > 0) {
            const reasonError = document.getElementById('reasonError');
            if (reasonError) reasonError.style.display = 'none';
          }

          // Update payment calculation when reasons change
          updatePaymentAmount();
        });
      });

      // Form validation - only apply to application form, not logout form
      const applicationForm = document.querySelector('form:not(.nav-logout-form)');
      if (applicationForm) {
        applicationForm.addEventListener('submit', function(e) {
          const checkedBoxes = document.querySelectorAll('.reason-checkbox:checked');
          if (checkedBoxes.length === 0) {
            e.preventDefault();
            const reasonError = document.getElementById('reasonError');
            if (reasonError) {
              reasonError.style.display = 'block';
              reasonError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
          }
        });
      }

      // Add focus effects to form inputs and selects
      const inputs = document.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select');
      inputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.style.borderColor = 'var(--primary-green)';
          this.style.boxShadow = '0 0 0 3px rgba(0, 176, 80, 0.1)';
        });

        input.addEventListener('blur', function() {
          this.style.borderColor = '#e1e5e9';
          this.style.boxShadow = 'none';
        });
      });
    });

    // Payment calculation function
    function updatePaymentAmount() {
      const copiesInput = document.getElementById('num_copies');
      const totalAmountSpan = document.getElementById('totalAmount');
      const paymentCalculationSpan = document.getElementById('paymentCalculation');

      const copies = parseInt(copiesInput.value) || 1;
      const checkedReasons = document.querySelectorAll('.reason-checkbox:checked').length || 1;
      const ratePerUnit = 50;
      const totalAmount = checkedReasons * copies * ratePerUnit;

      totalAmountSpan.textContent = `₱${totalAmount.toFixed(2)}`;

      const reasonText = checkedReasons === 1 ? 'reason' : 'reasons';
      const copyText = copies === 1 ? 'copy' : 'copies';
      paymentCalculationSpan.textContent = `${checkedReasons} ${reasonText} × ${copies} ${copyText} × ₱${ratePerUnit}.00`;
    }

    // Initialize payment calculation on page load
    document.addEventListener('DOMContentLoaded', function() {
      updatePaymentAmount();
    });

    // Course fields are now static and populated from student profile
    // No JavaScript needed for course selection
  </script>



  <style>
    /* Application Process Guide Responsive Styling */
    .process-guide-title {
      color: var(--primary-green);
      margin-bottom: 16px;
      font-size: 1.2rem;
      font-weight: 600;
    }

    .process-guide-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .process-guide-card {
      padding: 20px;
      border-radius: 8px;
      border-left: 4px solid;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .process-guide-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .process-flow-card {
      background: #e8f5e8;
      border-left-color: #28a745;
    }

    .processing-time-card {
      background: #fff3cd;
      border-left-color: #ffc107;
    }

    .help-card {
      background: #d1ecf1;
      border-left-color: #17a2b8;
    }

    .process-guide-card-title {
      font-weight: 600;
      margin-bottom: 12px;
      font-size: 1rem;
    }

    .process-flow-card .process-guide-card-title {
      color: #155724;
    }

    .processing-time-card .process-guide-card-title {
      color: #856404;
    }

    .help-card .process-guide-card-title {
      color: #0c5460;
    }

    .process-flow-list {
      margin: 0;
      padding-left: 20px;
      line-height: 1.6;
      color: #155724;
    }

    .process-flow-list li {
      margin-bottom: 4px;
    }

    .process-guide-text {
      line-height: 1.6;
      margin: 0;
    }

    .processing-time-card .process-guide-text {
      color: #856404;
    }

    .help-card .process-guide-text {
      color: #0c5460;
    }

    /* Mobile Responsive Design */
    @media (max-width: 768px) {
      .process-guide-title {
        font-size: 1.1rem;
        margin-bottom: 12px;
        text-align: center;
      }

      .process-guide-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .process-guide-card {
        padding: 16px;
        margin: 0 4px;
      }

      .process-guide-card-title {
        font-size: 0.95rem;
        margin-bottom: 10px;
      }

      .process-flow-list {
        padding-left: 16px;
        font-size: 14px;
      }

      .process-guide-text {
        font-size: 14px;
      }
    }

    /* Small Mobile Devices */
    @media (max-width: 480px) {
      .process-guide-title {
        font-size: 1rem;
      }

      .process-guide-card {
        padding: 12px;
        margin: 0 2px;
      }

      .process-guide-card-title {
        font-size: 0.9rem;
        margin-bottom: 8px;
      }

      .process-flow-list {
        padding-left: 14px;
        font-size: 13px;
      }

      .process-guide-text {
        font-size: 13px;
      }
    }

    /* Tablet Landscape */
    @media (min-width: 769px) and (max-width: 1024px) {
      .process-guide-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .process-guide-card:last-child {
        grid-column: 1 / -1;
        max-width: 50%;
        margin: 0 auto;
      }
    }

    /* Large Screens */
    @media (min-width: 1200px) {
      .process-guide-grid {
        gap: 24px;
      }

      .process-guide-card {
        padding: 24px;
      }
    }

    /* Static course field styling */
    .static-field {
      padding: 12px 16px;
      background: #f8f9fa;
      border: 2px solid #e1e5e9;
      border-radius: 8px;
      color: #333;
      font-size: 14px;
      line-height: 1.4;
      min-height: 44px;
      display: flex;
      align-items: center;
    }

    .static-field.error {
      background: #fff5f5;
      border-color: #fed7d7;
      color: #c53030;
    }

    .static-field .course-code {
      font-weight: 600;
      color: #2d3748;
      background: #edf2f7;
      padding: 2px 8px;
      border-radius: 4px;
      margin-right: 8px;
      font-size: 13px;
    }

    .static-field .course-name {
      color: #4a5568;
      flex: 1;
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

    /* Mobile-specific improvements */
    @media (max-width: 768px) {
      .static-field {
        font-size: 13px;
        padding: 10px 12px;
        min-height: 40px;
      }

      .static-field .course-code {
        font-size: 12px;
        padding: 1px 6px;
      }
    }

    /* Enhanced styling for remaining form elements */
    select.responsive-form-input {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 12px center;
      background-repeat: no-repeat;
      background-size: 16px;
      padding-right: 40px;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
    }

    select.responsive-form-input:focus {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2300b050' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    }

    /* Option styling */
    select.responsive-form-input option {
      padding: 8px 12px;
      font-size: 14px;
      line-height: 1.4;
    }

    /* Mobile-specific improvements for selects */
    @media (max-width: 768px) {
      select.responsive-form-input {
        font-size: 16px; /* Prevents zoom on iOS */
        padding: 14px 40px 14px 16px;
      }
    }
  </style>

  <!-- Notification JavaScript -->
  <script>
    // Function to update student/alumni notification counts
    function updateStudentNotificationCounts() {
      fetch('/student/notification-counts')
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Student/Alumni notification data received:', data);

          // Update application notifications
          updateNotificationBell('student-notifications', data.applicationNotifications || 0);

          // Update violation notifications
          updateNotificationBell('student-violations', data.violationNotifications || 0);

          // Update page title with total count
          const totalCount = data.totalNotifications || 0;
          if (totalCount > 0) {
            document.title = `(${totalCount}) {{ $roleTitle }} Dashboard - Good Moral Application System`;
          } else {
            document.title = '{{ $roleTitle }} Dashboard - Good Moral Application System';
          }
        })
        .catch(error => {
          console.error('Error fetching student/alumni notification counts:', error);
        });
    }

    // Function to update individual notification bell
    function updateNotificationBell(bellId, count) {
      console.log(`Updating notification bell: ${bellId} with count: ${count}`);

      const bell = document.getElementById(bellId + '-bell');
      const countElement = document.getElementById(bellId + '-count');

      console.log(`Bell element found: ${!!bell}, Count element found: ${!!countElement}`);

      if (bell && countElement) {
        const previousCount = parseInt(countElement.textContent) || 0;
        console.log(`Previous count: ${previousCount}, New count: ${count}`);

        if (count > 0) {
          bell.style.display = 'block';
          countElement.textContent = count;

          console.log(`Bell ${bellId} is now visible with count ${count}`);

          // Add animation effect for new or increased notifications
          if (count > previousCount) {
            bell.style.animation = 'bounce 0.6s ease-in-out';
            setTimeout(() => {
              bell.style.animation = '';
            }, 600);
          }

          // Add urgent styling for high counts
          if (bellId.includes('violations')) {
            // Violation notifications are always red
            bell.style.background = '#dc3545';
            bell.style.color = 'white';
          } else {
            // Application notifications styling based on count
            if (count >= 10) {
              bell.style.background = '#dc3545';
              bell.style.color = 'white';
            } else if (count >= 5) {
              bell.style.background = '#ff6b35';
              bell.style.color = 'white';
            } else {
              bell.style.background = '#ffc107';
              bell.style.color = '#333';
            }
          }
        } else {
          bell.style.display = 'none';
          console.log(`Bell ${bellId} is now hidden`);
        }
      } else {
        console.error(`Could not find bell elements for ${bellId}`);
      }
    }

    // Initialize notification counts when page loads
    document.addEventListener('DOMContentLoaded', function() {
      console.log('{{ $roleTitle }} dashboard loaded, initializing notifications...');

      // Check if notification bell elements exist
      const appBell = document.getElementById('student-notifications-bell');
      const violBell = document.getElementById('student-violations-bell');
      console.log('Application bell found:', !!appBell);
      console.log('Violation bell found:', !!violBell);

      updateStudentNotificationCounts();

      // Update notification counts every 30 seconds
      setInterval(updateStudentNotificationCounts, 30000);
    });

    // Add bounce animation keyframes
    const style = document.createElement('style');
    style.textContent = `
      @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-3px); }
        60% { transform: translateY(-2px); }
      }
    `;
    document.head.appendChild(style);
  </script>

</x-dashboard-layout>
