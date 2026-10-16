# ĐẶC TẢ YÊU CẦU HỆ THỐNG DT-16

## 1. Thông tin đề tài

- Mã đề tài: ĐT-16
- Tên đề tài: Bảo tàng ảo và tour tham quan 360° trên nền web
- Học phần: CSE703073 - Lập trình ứng dụng web trong du lịch 2

## 2. Bối cảnh và vấn đề

Tham quan ảo mở rộng khả năng tiếp cận di sản cho người không
thể trực tiếp đến bảo tàng.

Tuy nhiên, nếu hệ thống chỉ trình chiếu ảnh toàn cảnh, người
dùng có thể thiếu thông tin giải thích hiện vật và thiếu lộ trình
dẫn dắt.

DT-16 hướng tới trải nghiệm tham quan có cấu trúc, kết hợp
không gian 360°, thông tin hiện vật, hotspot, thuyết minh đa ngữ,
tuyến tham quan và tiến trình trải nghiệm.

## 3. Nhóm người dùng

### 3.1. Khách tham quan

- Xem thông tin bảo tàng và hiện vật.
- Tham quan không gian 360°.
- Sử dụng hotspot và Gateway.
- Xem tour và tham gia tour.
- Nghe thuyết minh.
- Lưu hiện vật và tour yêu thích.
- Gửi đánh giá, phản hồi hoặc lưu bút.

### 3.2. Quản trị viên

- Quản lý hiện vật.
- Quản lý không gian, điểm nhìn và ảnh panorama.
- Quản lý Gateway và hotspot.
- Quản lý tour và thứ tự điểm dừng.
- Quản lý tài khoản người dùng.
- Kiểm duyệt đánh giá và phản hồi.
- Xem thống kê hoạt động.

## 4. Yêu cầu chức năng

### F01. Đăng ký tài khoản

Cho phép khách tham quan tạo tài khoản để sử dụng các chức năng
cá nhân như lưu tour và hiện vật yêu thích.

### F02. Đăng nhập và đăng xuất

Cho phép người dùng đăng nhập và đăng xuất an toàn.

### F03. Quản lý thông tin cá nhân

Cho phép người dùng xem, chỉnh sửa và cập nhật thông tin cá nhân
trong phạm vi được phép.

### F04. Xem danh sách hiện vật

Hiển thị danh sách hiện vật, tác phẩm và tư liệu trưng bày.

### F05. Tìm kiếm hiện vật

Cho phép tìm theo tên, từ khóa hoặc thông tin liên quan.

### F06. Xem chi tiết hiện vật

Hiển thị hình ảnh, tên, nguồn gốc, thời kỳ, chất liệu và nội dung
giới thiệu chi tiết.

### F07. Tham quan không gian 360°

Cho phép người dùng xem không gian bảo tàng bằng panorama 360°.

### F08. Điều hướng trong không gian 360°

Cho phép xoay góc nhìn và di chuyển giữa các phòng, khu vực
hoặc điểm nhìn.

### F09. Xem điểm tương tác

Cho phép người dùng chọn các điểm tương tác được đặt trong
không gian 360°.

### F10. Xem thông tin tại điểm tham quan

Hiển thị thông tin giới thiệu về hiện vật, khu vực hoặc địa điểm
khi người dùng chọn hotspot.

### F11. Xem danh sách tour

Hiển thị tên tour, chủ đề, thời lượng và mô tả.

### F12. Bắt đầu tour tham quan

Cho phép chọn một tour và bắt đầu theo thứ tự điểm tham quan
đã được cấu hình.

### F13. Theo dõi tiến trình tour

Hiển thị vị trí hiện tại, điểm đã tham quan và tiến độ hoàn thành.

### F14. Xem nội dung đa phương tiện

Cho phép xem ảnh, video và nghe audio liên quan đến hiện vật
hoặc không gian.

### F15. Yêu thích hiện vật và tour

Cho phép lưu hiện vật hoặc tour yêu thích để xem lại.

### F16. Đánh giá và phản hồi

Cho phép người dùng gửi đánh giá, nhận xét hoặc phản hồi.

### F17. Quản lý hiện vật

Quản trị viên có thể thêm, sửa, xóa và cập nhật hiện vật.

### F18. Quản lý không gian 360°

Quản trị viên có thể thêm, cập nhật, xóa và cấu hình không gian
hoặc ảnh 360°.

### F19. Quản lý tour

Quản trị viên có thể tạo, sửa, sắp xếp và xóa tour.

### F20. Quản lý tài khoản

Quản trị viên có thể xem, cập nhật, khóa hoặc mở khóa tài khoản
theo quyền được cấp.

### F21. Quản lý đánh giá

Quản trị viên có thể xem, kiểm duyệt và xử lý phản hồi không phù hợp.

### F22. Thống kê hệ thống

Cung cấp dữ liệu về lượt truy cập, lượt xem hiện vật, lượt tham quan
tour và hoạt động của người dùng.

## 5. Nhóm chức năng đặc thù 360°

Các thành phần sau phải được đưa vào thiết kế:

- Panorama 360°.
- Gateway hoặc điểm chuyển cảnh.
- MiniMap.
- Hotspot hiện vật.
- Bảng thông tin hiện vật.
- Audio tiếng Việt.
- Audio tiếng Anh.
- Tuyến tham quan theo chủ đề.
- Chế độ tham quan tự do.
- Chế độ tham quan có hướng dẫn.
- Bộ sưu tập cá nhân.
- Thống kê lượt tham quan.

### Mô hình tọa độ hotspot

Hotspot phải gắn với điểm nhìn và sử dụng hệ tọa độ phù hợp
với thư viện panorama được chọn. Dự kiến dùng các góc yaw và pitch.

Quy ước đơn vị, chiều trục và cách ánh xạ tọa độ phải được thống
nhất giữa Backend và Frontend trước khi triển khai.

### Mô hình chuyển cảnh

Gateway phải xác định điểm nhìn nguồn và điểm nhìn đích hợp lệ.
Hệ thống cần xử lý trường hợp điểm nhìn đích không tồn tại
hoặc tài nguyên panorama chưa tải được.

## 6. Yêu cầu phi chức năng

### NF01. Hiệu năng

Các thao tác thông thường như mở trang, tìm kiếm và xem thông tin
phải phản hồi nhanh, hạn chế gián đoạn.

### NF02. Tốc độ tải

Tối ưu ảnh, âm thanh, video và dữ liệu để giảm thời gian tải.

### NF03. Hiển thị 360°

Panorama hiển thị mượt, đúng góc nhìn và hạn chế hiện tượng giật,
méo hoặc lỗi khi thao tác.

### NF04. Khả năng tương thích

Kiểm thử trên Chrome, Edge, Firefox và Safari trong phạm vi
thiết bị có thể tiếp cận.

### NF05. Responsive

Giao diện phù hợp với máy tính, máy tính bảng và điện thoại.

### NF06. Dễ sử dụng

Điều hướng trực quan, thao tác tham quan dễ hiểu.

### NF07. Bảo mật

Bảo vệ thông tin tài khoản và dữ liệu khỏi truy cập trái phép.

### NF08. Phân quyền

Người dùng chỉ thực hiện được các chức năng được cấp phép.

### NF09. Toàn vẹn dữ liệu

Dữ liệu hiện vật, tour, không gian và tài khoản phải chính xác,
nhất quán, hạn chế mất mát.

### NF10. Tính ổn định

Hệ thống hoạt động ổn định trong khi tham quan, tìm kiếm
và tương tác.

### NF11. Khả năng mở rộng

Có thể bổ sung hiện vật, không gian, tour và nội dung 360° mới.

### NF12. Khả năng bảo trì

Mã nguồn, cơ sở dữ liệu và cấu trúc hệ thống rõ ràng,
dễ sửa lỗi và nâng cấp.

### NF13. Sao lưu và phục hồi

Dữ liệu quan trọng được sao lưu định kỳ và có thể phục hồi.

### NF14. Khả năng chịu tải

Hệ thống phục vụ nhiều người dùng đồng thời trong phạm vi
tải được thiết kế và kiểm thử.

### NF15. Tối ưu tài nguyên

Nén và tối ưu ảnh 360°, video, audio để tiết kiệm băng thông.

### NF16. Tính chính xác nội dung

Thông tin lịch sử, văn hóa và giới thiệu hiện vật phải dựa trên
nguồn dữ liệu có thể kiểm chứng.

### NF17. Tính nhất quán giao diện

Các trang có bố cục, thuật ngữ, điều hướng và cách trình bày
nhất quán.

## 7. Tối ưu tài nguyên panorama

Xem xét các kỹ thuật:

- Lazy loading.
- Chỉ tải tài nguyên cần thiết cho điểm nhìn hiện tại.
- Tối ưu kích thước và định dạng ảnh.
- Sử dụng ảnh dạng tile/pyramid nếu phù hợp với thư viện.
- Cache tài nguyên phù hợp.
- Xử lý trạng thái đang tải, lỗi và thử tải lại.

Phân mảnh ảnh chỉ triển khai sau khi xác minh khả năng hỗ trợ
của thư viện và định dạng nguồn.

## 8. Thách thức nâng cao

### 8.1. Phân tích điểm bỏ dở

Phân tích sự kiện tham quan để nhận diện điểm nhìn hoặc tour
có tỷ lệ dừng giữa chừng cao.

### 8.2. Tham quan đồng hành nhiều người dùng

Xem xét chế độ cho nhiều người dùng cùng tham gia một hành trình.
Chỉ triển khai sau khi chức năng tham quan một người dùng
đã ổn định.

## 9. Nguyên tắc kiến trúc

- Frontend không kết nối trực tiếp đến MySQL.
- Backend chịu trách nhiệm xác thực, phân quyền và nghiệp vụ.
- Các API có hợp đồng dữ liệu rõ ràng.
- Thông tin nhạy cảm được lấy từ biến môi trường.
- Không đưa file .env thật lên GitHub.
- Mọi thao tác quản trị phải được kiểm soát quyền ở máy chủ.

## 10. Tài nguyên bảo tàng

Các nguồn bảo tàng được xem xét cho dữ liệu mẫu gồm:

- Naturalis Biodiversity Center.
- Deutsches Historisches Museum.
- Museum House Rams Woerthe.

Đây là danh sách nguồn cần xác minh, không phải xác nhận rằng
mọi ảnh hoặc audio tại các nguồn trên đều được phép sử dụng.

Trước khi đưa tài nguyên vào dự án, phải xác minh giấy phép,
điều kiện ghi công, quyền chỉnh sửa và cách phân phối lại.

## 11. Phạm vi triển khai

Website phải chạy trực tuyến trên Hostinger qua HTTPS.

Khả năng triển khai Laravel, MySQL và mô-đun Python phải được
đối chiếu với gói hosting cụ thể trước khi chốt cấu hình production.

## 12. Tiêu chí nghiệm thu tổng quát

- Đối chiếu tất cả yêu cầu chức năng.
- Đối chiếu tất cả yêu cầu phi chức năng.
- Kiểm thử các luồng tham quan từ đầu đến cuối.
- Kiểm thử quyền truy cập và dữ liệu không hợp lệ.
- Kiểm thử trên môi trường online.
- Lưu báo cáo kiểm thử và minh chứng thực tế.
