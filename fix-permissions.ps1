# Script sửa lỗi phân quyền khi pull code từ GitHub
# Chạy script này nếu gặp lỗi phân quyền

Write-Host "=== FIX PERMISSIONS SCRIPT ===" -ForegroundColor Green
Write-Host ""

# 1. Tắt git tracking file permissions
Write-Host "1. Tắt git file mode tracking..." -ForegroundColor Yellow
git config core.fileMode false
Write-Host "   ✓ Đã tắt file mode tracking" -ForegroundColor Green
Write-Host ""

# 2. Cấp quyền cho storage và bootstrap/cache
Write-Host "2. Cấp quyền cho thư mục storage..." -ForegroundColor Yellow
if (Test-Path "storage") {
    icacls "storage" /grant Everyone:F /T /C /Q
    Write-Host "   ✓ Đã cấp quyền cho storage" -ForegroundColor Green
} else {
    Write-Host "   ! Không tìm thấy thư mục storage" -ForegroundColor Red
}
Write-Host ""

Write-Host "3. Cấp quyền cho bootstrap/cache..." -ForegroundColor Yellow
if (Test-Path "bootstrap\cache") {
    icacls "bootstrap\cache" /grant Everyone:F /T /C /Q
    Write-Host "   ✓ Đã cấp quyền cho bootstrap/cache" -ForegroundColor Green
} else {
    Write-Host "   ! Không tìm thấy thư mục bootstrap/cache" -ForegroundColor Red
}
Write-Host ""

# 3. Clear cache Laravel
Write-Host "4. Xóa cache Laravel..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
Write-Host "   ✓ Đã xóa cache" -ForegroundColor Green
Write-Host ""

# 4. Recreate cache
Write-Host "5. Tạo lại cache..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
Write-Host "   ✓ Đã tạo lại cache" -ForegroundColor Green
Write-Host ""

Write-Host "=== HOÀN THÀNH ===" -ForegroundColor Green
Write-Host ""
Write-Host "Nếu vẫn còn lỗi, hãy chạy lệnh:" -ForegroundColor Cyan
Write-Host "   composer dump-autoload" -ForegroundColor White
Write-Host ""
