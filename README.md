# DT-16 - Bảo tàng ảo và tour tham quan 360° trên nền web

## 1. Giới thiệu

DT-16 là dự án xây dựng hệ thống bảo tàng ảo và tour tham quan 360°
trên nền web. Mục tiêu là tạo trải nghiệm khám phá có cấu trúc,
kết hợp hình ảnh toàn cảnh với thông tin hiện vật, thuyết minh,
điều hướng không gian và các tuyến tham quan có chủ đề.

Dự án thuộc học phần CSE703073 - Lập trình ứng dụng web trong du lịch 2.

## 2. Vấn đề cần giải quyết

Tham quan ảo giúp người dùng tiếp cận di sản từ xa. Tuy nhiên,
trải nghiệm chỉ có ảnh panorama sẽ thiếu lớp tri thức và thiếu
lộ trình dẫn dắt.

Hệ thống cần kết hợp không gian 360°, hiện vật, điểm tương tác,
nội dung đa ngữ và tiến trình tham quan để tạo trải nghiệm có ý nghĩa.

## 3. Phạm vi chức năng

- Tham quan không gian bằng panorama 360°.
- Điều hướng giữa các điểm nhìn bằng Gateway.
- MiniMap thể hiện vị trí và các điểm tham quan.
- Hotspot gắn với hiện vật và thông tin giới thiệu.
- Thuyết minh âm thanh tiếng Việt và tiếng Anh.
- Tour tham quan theo chủ đề.
- Chế độ tham quan tự do và chế độ có hướng dẫn.
- Tài khoản, hồ sơ cá nhân và bộ sưu tập yêu thích.
- Sổ lưu bút, đánh giá và phản hồi.
- Quản trị hiện vật, không gian, điểm nhìn, hotspot, tour và tài khoản.
- Thống kê lượt tham quan và hoạt động của người dùng.
- Phân tích điểm bỏ dở và các tính năng nâng cao khi nền tảng ổn định.

Danh mục yêu cầu chi tiết nằm trong:
01_BaoCao/01_DacTaYeuCau.md

## 4. Công nghệ dự kiến

- Frontend: Vue 3 + Vite.
- Backend: PHP + Laravel REST API.
- Cơ sở dữ liệu: MySQL.
- Phân tích dữ liệu: Python, có thể sử dụng FastAPI.
- Quản lý mã nguồn: Git và GitHub.
- Môi trường triển khai: Hostinger, sử dụng HTTPS.

Phiên bản framework và phương án triển khai cuối cùng sẽ được
chốt sau khi đối chiếu yêu cầu môn học, môi trường thực tế
và khả năng hỗ trợ của gói Hostinger.

## 5. Kiến trúc

Frontend gửi yêu cầu đến Backend thông qua API.
Backend xử lý xác thực, phân quyền và nghiệp vụ trước khi
đọc hoặc ghi dữ liệu MySQL.

Frontend không kết nối trực tiếp đến MySQL.

Mô-đun Python xử lý dữ liệu thông qua giao diện tích hợp
được thiết kế riêng.

## 6. Cấu trúc repository

- 01_BaoCao: đặc tả, báo cáo và minh chứng.
- 02_SourceCode/frontend: ứng dụng Vue.
- 02_SourceCode/laravel: Backend Laravel.
- 02_SourceCode/python-analytics: mô-đun Python.
- 02_SourceCode/docker: cấu hình môi trường khi cần.
- 03_Database: ghi chú mô hình dữ liệu và dữ liệu mẫu.
- 04_HuongDanSuDung: hướng dẫn sử dụng.
- 05_KiemThu: ca kiểm thử và kết quả.
- 06_Demo: kế hoạch demo và tài nguyên trình bày.
- 07_QuanTriDuAn: kế hoạch và quản trị dự án.
- tools: script PowerShell hỗ trợ phát triển.

## 7. Trạng thái dự án

Giai đoạn hiện tại: Khởi động dự án và thiết lập GitHub.

Các chức năng chưa được triển khai không được coi là đã hoàn thành.

## 8. Nguyên tắc bảo mật và dữ liệu

- Không đưa mật khẩu, token hoặc file .env thật lên GitHub.
- Không sử dụng ảnh, audio hoặc video nếu chưa xác minh quyền sử dụng.
- Không lưu mật khẩu người dùng dưới dạng văn bản thuần.
- Backend phải kiểm soát quyền truy cập.
- Có kế hoạch kiểm thử, sao lưu và phục hồi dữ liệu.
- Website phải được kiểm tra trên môi trường triển khai thực tế.

## 9. Trạng thái triển khai

Website Hostinger: Chưa triển khai.

Tên miền: Chưa chốt.

HTTPS: Sẽ kiểm tra sau khi triển khai.

## 10. Hướng dẫn

Hướng dẫn cài đặt, chạy ứng dụng và triển khai sẽ được cập nhật
khi các thành phần Backend, Frontend và Python được khởi tạo.
