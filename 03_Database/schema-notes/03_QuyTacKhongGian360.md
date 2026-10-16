# QUY TẮC THIẾT KẾ KHÔNG GIAN 360° - DT-16

## 1. Mục tiêu

Tài liệu thống nhất mô hình không gian, điểm nhìn, Gateway,
hotspot, MiniMap và metadata panorama.

Mọi quy tắc trong tài liệu này là quy ước nội bộ của DT-16.
Trước khi tích hợp thư viện panorama, cần xác minh cách quy đổi
tọa độ của thư viện sang quy ước nội bộ.

## 2. Các đối tượng

### 2.1. Museum

Đại diện cho một bảo tàng hoặc bộ sưu tập bảo tàng.

Một museum chứa nhiều space.

### 2.2. Space

Đại diện cho phòng trưng bày, khu vực hoặc một phần không gian.

Một space có thể có nhiều viewpoint.
Một space có thể có space con.

### 2.3. Viewpoint

Đại diện cho một vị trí quan sát trong space.

Một viewpoint có:
- Tiêu đề.
- Space chứa nó.
- Panorama chính.
- Góc nhìn ban đầu.
- Tọa độ trên MiniMap nếu có.
- Danh sách Gateway đi ra.
- Danh sách hotspot.
- Trạng thái xuất bản.

### 2.4. Gateway

Đại diện cho điểm tương tác dùng để chuyển từ viewpoint nguồn
sang viewpoint đích.

Gateway có:
- Viewpoint nguồn.
- Viewpoint đích.
- Nhãn hiển thị.
- Tọa độ đặt điểm tương tác trên panorama nguồn.
- Góc nhìn đích tùy chọn.
- Trạng thái hoạt động.

### 2.5. Hotspot

Đại diện cho một điểm tương tác trên panorama.

Hotspot có thể:
- Liên kết tới một artifact.
- Hiển thị nội dung giới thiệu.
- Hiển thị nội dung tương tác được hệ thống hỗ trợ.

Hotspot phải thuộc một viewpoint.

## 3. Quy ước tọa độ cầu

DT-16 sử dụng quy ước dữ liệu nội bộ như sau:

### Yaw

- Tên cột: yaw_deg.
- Đơn vị: độ.
- Khoảng lưu chuẩn: từ -180 đến 180.
- Giá trị 0 đại diện cho hướng nhìn chuẩn của viewpoint.
- Giá trị dương đại diện cho hướng quay sang phải theo quy ước nội bộ.
- Giá trị âm đại diện cho hướng quay sang trái.

### Pitch

- Tên cột: pitch_deg.
- Đơn vị: độ.
- Khoảng hợp lệ: từ -90 đến 90.
- Giá trị 0 đại diện cho đường chân trời.
- Giá trị dương hướng lên trên.
- Giá trị âm hướng xuống dưới.

Các quy tắc này là quy ước dữ liệu nội bộ.
Frontend phải chuyển đổi nếu thư viện panorama sử dụng
cách biểu diễn khác.

Không trộn độ với radian.
Không tự ý thay đổi đơn vị giữa Backend và Frontend.
Không giả định thư viện panorama nào cũng dùng cùng quy ước.

## 4. Góc nhìn ban đầu

Mỗi viewpoint có:
- initial_yaw_deg.
- initial_pitch_deg.

Khi người dùng mở viewpoint, Frontend đọc hai giá trị này
để đặt góc nhìn ban đầu theo quy tắc đã thống nhất.

Nếu không có giá trị riêng, dùng mặc định:
- initial_yaw_deg = 0
- initial_pitch_deg = 0

Giá trị cuối cùng phải nằm trong phạm vi hợp lệ.

## 5. Vị trí hotspot

Mỗi hotspot có:
- viewpoint_id.
- yaw_deg.
- pitch_deg.

Backend kiểm tra:
- viewpoint_id tồn tại.
- yaw_deg và pitch_deg là số hợp lệ.
- artifact_id tồn tại khi hotspot yêu cầu liên kết artifact.
- hotspot được phép xuất bản trước khi hiển thị công khai.

Frontend:
1. Tải cấu hình viewpoint.
2. Đọc tọa độ hotspot.
3. Quy đổi tọa độ sang hệ tọa độ của thư viện panorama.
4. Hiển thị hotspot đúng vị trí.
5. Mở thông tin tương ứng khi người dùng tương tác.

Không đặt vị trí hotspot bằng pixel cố định trên màn hình.
Vị trí tương tác phải gắn với tọa độ panorama để giữ đúng vị trí
khi người dùng xoay hoặc phóng to/thu nhỏ.

## 6. Gateway

Một Gateway gồm:
- from_viewpoint_id.
- to_viewpoint_id.
- yaw_deg.
- pitch_deg.
- target_yaw_deg tùy chọn.
- target_pitch_deg tùy chọn.
- label.
- is_active.

Luồng chuyển cảnh:
1. Người dùng chọn Gateway trên panorama nguồn.
2. Frontend xác định Gateway được chọn.
3. Frontend lấy cấu hình của viewpoint đích nếu chưa có.
4. Frontend tải panorama đích.
5. Khi tải thành công, Frontend chuyển sang viewpoint đích.
6. Nếu có target_yaw_deg và target_pitch_deg, sử dụng chúng
   làm góc nhìn đích theo quy tắc quy đổi.
7. Nếu tải thất bại, thông báo lỗi và không để giao diện
   rơi vào trạng thái không thể tiếp tục tham quan.

Backend phải kiểm tra điểm nguồn và điểm đích tồn tại.
Không trả Gateway không hoạt động ra cấu hình công khai.

## 7. MiniMap

Tọa độ MiniMap được chuẩn hóa:

- mini_map_x_norm: từ 0 đến 1.
- mini_map_y_norm: từ 0 đến 1.

Quy ước:
- x_norm = 0 là mép trái.
- x_norm = 1 là mép phải.
- y_norm = 0 là mép trên.
- y_norm = 1 là mép dưới.

Ví dụ:
- x_norm = 0.5.
- y_norm = 0.5.

Đó là vị trí trung tâm theo hệ tọa độ MiniMap đã chuẩn hóa.

MiniMap có thể hiển thị:
- Vị trí hiện tại.
- Các viewpoint có thể truy cập.
- Đường hoặc quan hệ chuyển cảnh nếu cần.
- Điểm đích của tour.

Tọa độ MiniMap không phải tọa độ cầu yaw/pitch.
Không dùng lẫn hai loại tọa độ này.

## 8. Panorama và chế độ tải tài nguyên

Các chế độ dự kiến:
- equirectangular: tải ảnh panorama toàn cảnh.
- tiled: sử dụng tài nguyên phân mảnh nếu thư viện và định dạng hỗ trợ.

Mỗi viewpoint cần xác định:
- panorama_asset_id.
- rendering_mode.
- tile_manifest_asset_id nếu sử dụng ảnh phân mảnh.

Nếu chỉ có ảnh panorama đầy đủ:
- rendering_mode = equirectangular.
- tile_manifest_asset_id = null.

Nếu sử dụng ảnh phân mảnh:
- Cần có manifest hoặc cấu hình mà thư viện được chọn hỗ trợ.
- Không tự tạo đường dẫn tile theo giả định.
- Kiểm tra mọi tài nguyên tham chiếu tồn tại.
- Chỉ bật chế độ tiled khi tài nguyên thực sự đáp ứng định dạng yêu cầu.

Không đưa dữ liệu ảnh panorama lớn vào JSON API.
API chỉ trả metadata và URL tài nguyên phù hợp.

## 9. Tải chậm

Frontend chỉ nên tải tài nguyên cần thiết.

Nguyên tắc:
- Không tải toàn bộ panorama của tất cả phòng ngay khi mở trang.
- Khi mở một viewpoint, ưu tiên panorama của viewpoint đó.
- Chỉ tải media bổ sung khi người dùng yêu cầu hoặc gần sử dụng.
- Không tạo nhiều yêu cầu lặp cho cùng một tài nguyên.
- Có trạng thái loading, error và retry.
- Tránh xóa tài nguyên đang sử dụng làm gián đoạn trải nghiệm.

## 10. An toàn tài nguyên

- Không trả đường dẫn ổ C của máy phát triển.
- URL media phải dùng được trên môi trường chạy thật.
- Kiểm tra quyền đọc tài nguyên cần bảo vệ.
- Không sử dụng tài nguyên chưa được phép.
- Lưu nguồn, giấy phép và thông tin ghi công khi cần.
- Không để một tài nguyên bị xóa làm phá vỡ âm thầm toàn bộ viewpoint.

## 11. Dữ liệu kiểm thử thiết kế

Dữ liệu thử sau sẽ được tạo trong giai đoạn seed:
- Một museum mẫu.
- Ít nhất hai space.
- Nhiều viewpoint để kiểm tra điều hướng.
- Một Gateway nối hai viewpoint.
- Một artifact mẫu.
- Một hotspot gắn với artifact.
- Một tour có nhiều tour_stop.
- Hai narration với language_code vi và en nếu có audio hợp lệ.

Đây là kế hoạch dữ liệu thử, chưa phải dữ liệu nội dung bảo tàng thực
và chưa xác nhận quyền sử dụng ảnh hoặc audio.

## 12. Tiêu chí chấp nhận

- Tọa độ lưu theo một quy ước thống nhất.
- Gateway có điểm nguồn và đích hợp lệ.
- Hotspot thuộc đúng viewpoint.
- MiniMap dùng tọa độ chuẩn hóa riêng.
- Panorama hỗ trợ chế độ tải đã cấu hình.
- Không trả đường dẫn tuyệt đối của máy lập trình.
- Có phương án xử lý lỗi khi tải panorama hoặc chuyển cảnh.
