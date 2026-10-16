# KIỂM TRA NGHIỆM THU PHẦN II - DT-16

## 1. Mục tiêu

Xác minh rằng kiến trúc, mô hình dữ liệu, quy tắc không gian 360°
và hợp đồng API đã được ghi thành tài liệu trước khi lập trình.

## 2. Kiến trúc

- [ ] Có mô tả Frontend.
- [ ] Có mô tả Backend.
- [ ] Có mô tả MySQL.
- [ ] Có mô tả mô-đun Python.
- [ ] Khẳng định Frontend không kết nối trực tiếp MySQL.
- [ ] Có mô tả triển khai trên Hostinger.
- [ ] Các quyết định công nghệ cần xác minh đã được ghi rõ.

## 3. Mô hình dữ liệu

- [ ] Có bảng users và roles.
- [ ] Có museums và spaces.
- [ ] Có viewpoints và gateways.
- [ ] Có artifacts và hotspots.
- [ ] Có media_assets và artifact_media.
- [ ] Có tours và tour_stops.
- [ ] Có narrations cho audio đa ngữ.
- [ ] Có dữ liệu yêu thích.
- [ ] Có reviews và guestbook_entries.
- [ ] Có visit_sessions, visit_session_stops và visit_events.
- [ ] Có danh sách quan hệ và thứ tự migration dự kiến.
- [ ] Có quy tắc toàn vẹn dữ liệu.

## 4. Quy tắc không gian 360°

- [ ] Có quy ước yaw_deg.
- [ ] Có quy ước pitch_deg.
- [ ] Có quy tắc tọa độ MiniMap riêng.
- [ ] Có quy tắc Gateway nguồn và đích.
- [ ] Có quy tắc hotspot gắn viewpoint.
- [ ] Có quy tắc tải panorama.
- [ ] Có ghi chú lazy loading và ảnh phân mảnh.
- [ ] Có quy tắc xử lý lỗi tài nguyên.

## 5. Hợp đồng REST API

- [ ] Có quy ước URL và phiên bản API.
- [ ] Có quy ước JSON thành công và lỗi.
- [ ] Có mã trạng thái HTTP.
- [ ] Có API tài khoản và hồ sơ.
- [ ] Có API hiện vật, không gian và điểm nhìn.
- [ ] Có API Gateway, hotspot và scene.
- [ ] Có API tour và tiến trình.
- [ ] Có API yêu thích, đánh giá và lưu bút.
- [ ] Có API ghi sự kiện tham quan.
- [ ] Có API quản trị.
- [ ] Có API thống kê.
- [ ] Có quy tắc xác thực và phân quyền.

## 6. An toàn và giấy phép dữ liệu

- [ ] Không lưu mật khẩu thuần.
- [ ] Không dùng URL ổ C trong API production.
- [ ] Không commit file .env thật.
- [ ] Có trường lưu nguồn và giấy phép của media.
- [ ] Có quy tắc kiểm tra media trước khi công khai.
- [ ] Có nguyên tắc không lưu dữ liệu nhạy cảm trong event_data.

## 7. Tiêu chí hoàn thành Phần II

Phần II chỉ đạt khi:
- Tất cả file thiết kế được lưu trong repository.
- Các bảng và quan hệ dữ liệu được giải thích.
- Quy tắc tọa độ 360° đã thống nhất.
- Frontend và Backend thống nhất hợp đồng API.
- Những quyết định chưa chắc chắn được ghi thành việc cần xác minh.
- Có kiểm tra PowerShell xác nhận file không rỗng.
- Các tài liệu đã được commit lên nhánh dev.

Phần II không yêu cầu:
- Chạy migration thật.
- Tạo bảng MySQL thật.
- Chạy Laravel API.
- Chạy Vue.
- Triển khai Hostinger.
