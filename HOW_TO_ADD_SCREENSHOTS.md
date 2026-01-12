# 📸 How to Add Screenshots to GitHub

This guide will walk you through capturing, organizing, and adding screenshots of your system to the GitHub repository.

---

## 🎯 **Quick Steps Overview**

1. Take screenshots of your system interface
2. Save them to the `screenshots/` folder
3. Commit and push to GitHub
4. Screenshots automatically display in README.md

---

## 📷 **Method 1: Taking Screenshots (Windows)**

### **Option A: Using Snipping Tool (Recommended)**
1. Press `Windows Key + Shift + S`
2. Select the area you want to capture
3. The screenshot is copied to clipboard
4. Open Paint or any image editor
5. Paste (`Ctrl + V`)
6. Save as PNG with descriptive name

### **Option B: Using Print Screen**
1. Press `PrtScn` (full screen) or `Alt + PrtScn` (active window)
2. Open Paint
3. Paste (`Ctrl + V`)
4. Save as PNG

### **Option C: Using Browser Extensions (For Web Pages)**
**Full Page Screen Capture (Chrome/Edge)**
1. Install "GoFullPage" or "Awesome Screenshot" extension
2. Click the extension icon
3. It captures the entire page (including scrollable areas)
4. Download the image

---

## 📁 **Step-by-Step: Adding Screenshots to GitHub**

### **Step 1: Take Screenshots of Each Section**

#### **Required Screenshots** (Based on README.md)
```
✅ login-page.png
✅ student-dashboard.png
✅ student-application-form.png
✅ student-application-status.png
✅ student-certificate-download.png
✅ moderator-dashboard.png
✅ moderator-add-violation.png
✅ moderator-escalation-queue.png
✅ dean-pending-applications.png
✅ dean-application-review.png
✅ admin-dashboard.png
✅ admin-violation-monitoring.png
✅ mobile-responsive.png (optional)
```

### **Step 2: Save Screenshots to the Folder**

**Navigate to your project folder:**
```
C:\Users\lovel\Desktop\capstoneasof\GoodMoralApplication\screenshots\
```

**Save each screenshot with the exact filename listed above**

Example:
- Take screenshot of login page → Save as `login-page.png`
- Take screenshot of student dashboard → Save as `student-dashboard.png`

---

### **Step 3: Commit and Push to GitHub**

**Open PowerShell in your project directory:**
```powershell
cd "C:\Users\lovel\Desktop\capstoneasof\GoodMoralApplication"
```

**Add the screenshots:**
```powershell
git add screenshots/
```

**Commit with a message:**
```powershell
git commit -m "Add system interface screenshots for documentation"
```

**Push to GitHub:**
```powershell
git push origin main
```

---

## 🎨 **Screenshot Best Practices**

### **Image Quality**
- ✅ Use PNG format (better quality than JPG for UI screenshots)
- ✅ Recommended resolution: 1920x1080 or 1366x768
- ✅ Keep file size under 500KB per image (compress if needed)

### **Content Guidelines**
- ✅ Use demo/test data (avoid real student information)
- ✅ Ensure UI is clean and professional
- ✅ Show complete features without cropping important elements
- ✅ Use consistent browser zoom level (100%)

### **File Naming**
- ✅ Use lowercase letters
- ✅ Use hyphens (-) instead of spaces or underscores
- ✅ Be descriptive: `student-application-form.png` not `screenshot1.png`

---

## 🖼️ **Image Optimization (Optional)**

If your images are too large, compress them:

### **Online Tools**
- [TinyPNG](https://tinypng.com/) - Free PNG compression
- [Squoosh](https://squoosh.app/) - Google's image optimizer
- [ImageOptim](https://imageoptim.com/) - Desktop app for Mac

### **Desktop Tools (Windows)**
- Paint - Resize and save with lower quality
- IrfanView - Batch resize and compress
- GIMP - Advanced image editing

---

## 🔄 **Updating Screenshots**

**If you need to replace a screenshot:**

1. Delete or rename the old file in `screenshots/` folder
2. Add the new screenshot with the same filename
3. Commit and push:
   ```powershell
   git add screenshots/
   git commit -m "Update [screenshot-name] with improved version"
   git push origin main
   ```

---

## 📋 **Complete Workflow Example**

### **Example: Adding Student Dashboard Screenshot**

**Step 1: Take Screenshot**
```
1. Open your system in browser
2. Login as student
3. Navigate to dashboard
4. Press Windows + Shift + S
5. Select and capture the dashboard
```

**Step 2: Save Image**
```
1. Open Paint
2. Paste (Ctrl + V)
3. Save As → Browse to screenshots folder
4. Filename: "student-dashboard.png"
5. Save as type: PNG
6. Click Save
```

**Step 3: Push to GitHub**
```powershell
# Navigate to project
cd "C:\Users\lovel\Desktop\capstoneasof\GoodMoralApplication"

# Add screenshot
git add screenshots/student-dashboard.png

# Commit
git commit -m "Add student dashboard screenshot"

# Push
git push origin main
```

**Step 4: Verify on GitHub**
```
1. Go to: https://github.com/solace1221/good-moral-application-and-monitoring-system
2. Navigate to screenshots/ folder
3. Click on student-dashboard.png to verify it uploaded
4. Check README.md to see it displayed
```

---

## ⚡ **Quick Commands**

### **Add all screenshots at once:**
```powershell
cd "C:\Users\lovel\Desktop\capstoneasof\GoodMoralApplication"
git add screenshots/
git commit -m "Add all system interface screenshots"
git push origin main
```

### **Check what screenshots are staged:**
```powershell
git status
```

### **See screenshot file sizes:**
```powershell
Get-ChildItem screenshots/ | Select-Object Name, @{Name="SizeKB";Expression={[math]::Round($_.Length/1KB,2)}}
```

---

## 🎯 **Checklist Before Pushing**

Before you commit screenshots, verify:

- [ ] All screenshots use demo/test data (no real student info)
- [ ] Filenames match exactly what's in README.md
- [ ] Images are in PNG format
- [ ] Screenshots are clear and properly sized
- [ ] All required screenshots are captured
- [ ] File sizes are reasonable (under 500KB each)

---

## 🆘 **Troubleshooting**

### **Problem: Screenshot doesn't show on GitHub README**
**Solution:**
- Check filename spelling (must match exactly)
- Ensure file is in `screenshots/` folder (not a subfolder)
- Verify the image actually uploaded (check GitHub web interface)
- Wait a few minutes for GitHub to process the image

### **Problem: Image file is too large**
**Solution:**
- Resize image to 1920x1080 or smaller
- Use TinyPNG.com to compress
- Save as PNG with lower quality settings

### **Problem: Screenshots show private data**
**Solution:**
- Delete the screenshot from `screenshots/` folder
- Use browser DevTools to edit text on page before screenshot
- Or create test/demo accounts with fake data

---

## 📚 **Additional Resources**

- [Markdown Image Syntax](https://www.markdownguide.org/basic-syntax/#images)
- [GitHub's Guide to Images in README](https://docs.github.com/en/get-started/writing-on-github/getting-started-with-writing-and-formatting-on-github/basic-writing-and-formatting-syntax#images)
- [Screenshot Best Practices](https://www.screenpresso.com/blog/screenshot-best-practices/)

---

**Need help?** Check the [screenshots/README.md](screenshots/README.md) for the complete list of required screenshots!

---

*Last Updated: October 5, 2025*