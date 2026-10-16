# THIẾT KẾ KIẾN TRÚC HỆ THỐNG DT-16

## 1. Mục đích

Tài liệu mô tả kiến trúc tổng thể của hệ thống Bảo tàng ảo
và tour tham quan 360° trên nền web.

Tài liệu này là căn cứ thống nhất cách phân chia trách nhiệm
giữa Frontend, Backend, cơ sở dữ liệu, tài nguyên đa phương tiện
và mô-đun phân tích dữ liệu.

## 2. Nguyên tắc kiến trúc

1. Frontend không kết nối trực tiếp đến MySQL.
2. Backend chịu trách nhiệm xử lý nghiệp vụ, xác thực,
   phân quyền và kiểm tra dữ liệu.
3. Frontend và Backend giao tiếp qua REST API có hợp đồng rõ ràng.
4. Tài nguyên ảnh, panorama, audio và video được quản lý
   bằng metadata và đường dẫn lưu trữ.
5. Không lưu mật khẩu, token hoặc bí mật trong mã nguồn.
6. Các chức năng quản trị phải được kiểm soát quyền ở máy chủ.
7. Những thay đổi về cấu trúc dữ liệu phải được quản lý
   bằng migration trong Backend.
8. Mỗi yêu cầu chức năng phải có cách kiểm thử tương ứng.
9. Mọi tài nguyên bên ngoài phải được kiểm tra nguồn và giấy phép.
10. Kiến trúc phải hỗ trợ triển khai trên Hostinger.

## 3. Thành phần hệ thống

### 3.1. Frontend

Công nghệ dự kiến:
- Vue 3.
- Vite.
- JavaScript hoặc TypeScript.
- Vue Router.
- Một thư viện trình chiếu panorama tương thích Vue 3.

Trách nhiệm:
- Hiển thị giao diện khách tham quan.
- Hiển thị danh sách và thông tin hiện vật.
- Hiển thị panorama 360°.
- Hiển thị Gateway và MiniMap.
- Hiển thị hotspot và nội dung hiện vật.
- Chạy trải nghiệm tour tham quan.
- Phát audio theo ngôn ngữ.
- Hiển thị tiến trình tour.
- Cung cấp chức năng cá nhân và trang quản trị.
- Gọi REST API của Backend.

Frontend không quyết định quyền truy cập cuối cùng.
Mọi API nhạy cảm phải được Backend bảo vệ.

### 3.2. Backend

Công nghệ dự kiến:
- PHP.
- Laravel.
- REST API.
- Laravel Eloquent ORM.
- Form Request hoặc cơ chế validation tương đương.
- API Resource hoặc cơ chế định dạng phản hồi thống nhất.

Trách nhiệm:
- Đăng ký, đăng nhập và đăng xuất.
- Quản lý hồ sơ và quyền người dùng.
- Quản lý bảo tàng, không gian và điểm nhìn.
- Quản lý Gateway, hotspot và hiện vật.
- Quản lý tour và thứ tự điểm dừng.
- Quản lý metadata ảnh, audio và video.
- Lưu yêu thích, phản hồi và lưu bút.
- Ghi nhận tiến trình và sự kiện tham quan.
- Cung cấp API thống kê.
- Kiểm tra quyền truy cập và tính hợp lệ dữ liệu.

### 3.3. Cơ sở dữ liệu

Công nghệ dự kiến: MySQL.

Cơ sở dữ liệu lưu:
- Tài khoản và vai trò.
- Bảo tàng và không gian.
- Điểm nhìn và liên kết chuyển cảnh.
- Hiện vật và hotspot.
- Metadata tài nguyên đa phương tiện.
- Tour và các điểm dừng.
- Thuyết minh theo ngôn ngữ.
- Yêu thích, đánh giá và lưu bút.
- Phiên tham quan và sự kiện hành vi.

Không nhúng trực tiếp file ảnh panorama hoặc audio dung lượng lớn
vào các cột dữ liệu thông thường của MySQL.

### 3.4. Mô-đun phân tích dữ liệu

Công nghệ dự kiến:
- Python.
- pandas nếu cần xử lý bảng.
- FastAPI nếu triển khai dưới dạng dịch vụ API.

Trách nhiệm:
- Xử lý sự kiện tham quan đã chuẩn hóa.
- Tính thống kê và tỷ lệ hoàn thành.
- Phân tích điểm nhìn hoặc tour có nhiều phiên bỏ dở.
- Cung cấp kết quả qua giao diện tích hợp được bảo vệ.

Không cho phép trình duyệt truy cập trực tiếp MySQL
hoặc cơ sở dữ liệu nội bộ của mô-đun Python.

Việc chạy Python liên tục trên môi trường production
phải được xác minh theo gói Hostinger thực tế.

## 4. Luồng xử lý tổng quát

1. Người dùng mở website.
2. Frontend tải giao diện.
3. Frontend gọi REST API.
4. Backend xác thực yêu cầu và kiểm tra quyền.
5. Backend truy vấn hoặc cập nhật MySQL.
6. Backend trả JSON về Frontend.
7. Frontend hiển thị nội dung.
8. Khi có sự kiện tham quan cần ghi nhận, Frontend gửi sự kiện
   qua API được thiết kế cho mục đích đó.
9. Backend lưu sự kiện và cung cấp dữ liệu cho phần thống kê.
10. Mô-đun Python xử lý dữ liệu đã chuẩn hóa khi được tích hợp.

## 5. Luồng tải panorama

1. Người dùng mở một điểm nhìn.
2. Frontend yêu cầu thông tin điểm nhìn qua API.
3. Backend trả metadata panorama, hotspot và Gateway.
4. Frontend tải tài nguyên panorama từ URL được cung cấp.
5. Frontend chỉ tải dữ liệu và tài nguyên cần thiết.
6. Khi người dùng chuyển điểm nhìn, Frontend lấy cấu hình
   của điểm nhìn đích.
7. Frontend hiển thị hotspot và Gateway tương ứng với điểm nhìn đó.

Không trả đường dẫn tuyệt đối trên ổ C của máy lập trình
cho trình duyệt hoặc người dùng production.

## 6. Vai trò người dùng

### Khách tham quan

Được phép:
- Xem dữ liệu công khai.
- Tham quan không gian 360°.
- Xem hiện vật và tour.
- Bắt đầu tour.
- Lưu yêu thích khi đăng nhập.
- Gửi đánh giá, phản hồi hoặc lưu bút theo chính sách.

Không được phép:
- Tự sửa dữ liệu bảo tàng.
- Thay đổi vai trò tài khoản.
- Truy cập API quản trị không được cấp quyền.

### Quản trị viên

Được phép theo phân quyền:
- Quản lý hiện vật.
- Quản lý không gian, điểm nhìn và Gateway.
- Quản lý hotspot và media.
- Quản lý tour.
- Quản lý tài khoản.
- Kiểm duyệt phản hồi.
- Xem thống kê.

Quyền phải được kiểm tra ở Backend.

## 7. Tổ chức repository

Repository duy nhất:
CSE703073-DT16-BaoTang360

Các thành phần mã nguồn:
- 02_SourceCode/frontend
- 02_SourceCode/laravel
- 02_SourceCode/python-analytics
- 02_SourceCode/docker

Tài liệu thiết kế:
- 03_Database/schema-notes

Tài liệu kiểm thử:
- 05_KiemThu

Tài liệu hướng dẫn:
- 04_HuongDanSuDung

## 8. Quyết định công nghệ cần xác minh

Laravel:
- Tài liệu học phần dùng Laravel 11 làm phương án tham chiếu.
- Laravel 11 đã hết thời hạn hỗ trợ bảo mật theo chính sách
  phát hành chính thức vào ngày 12/03/2026.
- Dự án mới cần đánh giá Laravel 13 và PHP tương thích,
  đồng thời kiểm tra yêu cầu chính thức của học phần.
- Không khởi tạo Backend trước khi quyết định phiên bản.

Vue:
- Dùng Vue 3 và Vite.
- Cấu hình dự án thực tế sẽ được tạo ở Phần VII.

MySQL:
- Chọn phiên bản tương thích với môi trường phát triển,
  Laravel và gói hosting.

Hostinger:
- Cần xác minh loại gói hosting.
- Cần xác minh phiên bản PHP, MySQL, SSH và Composer.
- Cần xác minh khả năng chạy dịch vụ Python.
- Cần xác minh cách phục vụ tài nguyên 360°.

## 9. Nguyên tắc triển khai

- Website phải truy cập công khai qua HTTPS.
- Production phải tắt chế độ debug.
- Bí mật được đọc từ biến môi trường.
- Thư mục public không được làm lộ mã nguồn hoặc file cấu hình.
- Media cần tồn tại bền vững sau khi ứng dụng khởi động lại.
- Phải có kế hoạch backup và kiểm tra phục hồi.
- Phải chạy kiểm thử trên môi trường trực tuyến.

## 10. Phạm vi chưa triển khai tại Phần II

Phần II chỉ hoàn thiện tài liệu thiết kế.
Chưa tạo migration thật.
Chưa tạo model Laravel.
Chưa tạo Vue component.
Chưa tạo API chạy thật.
Chưa triển khai website.

Các phần trên sẽ được thực hiện trong giai đoạn lập trình.
