# HỢP ĐỒNG REST API - DT-16

## 1. Mục đích

Tài liệu quy định endpoint, phương thức HTTP, quyền truy cập,
tham số chính và định dạng phản hồi cho Frontend và Backend.

Các endpoint ở tài liệu này là thiết kế thống nhất cho dự án.
Chúng chưa phải API đang chạy thật.

## 2. Quy ước URL

Tiền tố API:
  /api/v1

Tên tài nguyên dùng số nhiều khi phù hợp.
Dùng slug cho tài nguyên công khai có địa chỉ thân thiện.
Dùng ID hoặc UUID phù hợp cho tài nguyên nội bộ.

Không truyền mật khẩu hoặc thông tin nhạy cảm trong URL.
Không dùng đường dẫn tuyệt đối của máy lập trình trong response.

## 3. Quy ước phương thức HTTP

GET:
Đọc dữ liệu.

POST:
Tạo tài nguyên hoặc ghi nhận một hành động.

PATCH:
Cập nhật một phần tài nguyên.

PUT:
Thay thế toàn bộ tài nguyên khi có yêu cầu rõ ràng.

DELETE:
Xóa hoặc yêu cầu ngừng sử dụng tài nguyên theo chính sách.

Không sử dụng GET để thay đổi trạng thái dữ liệu.

## 4. Quy ước phản hồi thành công

Dữ liệu đơn:

{
  "data": {
    "id": 1,
    "title": "Ví dụ"
  }
}

Danh sách phân trang:

{
  "data": [],
  "meta": {
    "current_page": 1,
    "per_page": 12,
    "total": 0,
    "last_page": 1
  }
}

Một số thao tác không cần nội dung trả về có thể dùng HTTP 204.

## 5. Quy ước phản hồi lỗi

Ví dụ lỗi dữ liệu:

{
  "message": "Dữ liệu không hợp lệ.",
  "code": "VALIDATION_ERROR",
  "errors": {
    "title": [
      "Trường title là bắt buộc."
    ]
  }
}

Không trả stack trace, thông tin cấu hình, mật khẩu,
đường dẫn nội bộ hoặc câu lệnh SQL cho người dùng.

## 6. Mã trạng thái dự kiến

- 200: Thành công.
- 201: Tạo mới thành công.
- 204: Thành công, không có nội dung trả về.
- 400: Yêu cầu không hợp lệ.
- 401: Chưa xác thực.
- 403: Không có quyền.
- 404: Không tìm thấy tài nguyên.
- 409: Xung đột trạng thái hoặc dữ liệu.
- 422: Dữ liệu không vượt qua validation.
- 429: Gửi yêu cầu quá thường xuyên.
- 500: Lỗi máy chủ; không tiết lộ chi tiết nội bộ.

## 7. Danh sách endpoint công khai

### Bảo tàng

GET /api/v1/museums
Mục đích: danh sách bảo tàng đã xuất bản.

GET /api/v1/museums/{museumSlug}
Mục đích: chi tiết bảo tàng.

GET /api/v1/museums/{museumSlug}/spaces
Mục đích: danh sách không gian của bảo tàng.

### Hiện vật

GET /api/v1/artifacts
Mục đích: danh sách và tìm kiếm hiện vật.

Tham số dự kiến:
- q: từ khóa tìm kiếm.
- museum_id: lọc bảo tàng.
- space_id: lọc khu vực nếu có quan hệ phù hợp.
- page: trang.
- per_page: số bản ghi mỗi trang.

GET /api/v1/artifacts/{artifactSlug}
Mục đích: chi tiết hiện vật.

### Không gian 360°

GET /api/v1/spaces/{spaceId}/viewpoints
Mục đích: điểm nhìn thuộc một không gian.

GET /api/v1/viewpoints/{viewpointId}/scene
Mục đích: cấu hình cần cho một cảnh panorama.

Phản hồi scene phải đủ thông tin cần thiết để Frontend hiển thị:
- metadata viewpoint.
- metadata panorama.
- góc nhìn ban đầu.
- tọa độ MiniMap nếu có.
- danh sách Gateway đang hoạt động.
- danh sách hotspot được phép hiển thị.
- dữ liệu hiện vật liên quan.
- metadata audio hoặc nội dung liên quan khi cần.

### Tour

GET /api/v1/tours
Mục đích: danh sách tour đã xuất bản.

GET /api/v1/tours/{tourSlug}
Mục đích: chi tiết tour.

GET /api/v1/tours/{tourSlug}/stops
Mục đích: danh sách điểm dừng theo thứ tự.

### Lưu bút và phản hồi

GET /api/v1/guestbook
Mục đích: danh sách lưu bút đã được phép công khai.

POST /api/v1/guestbook
Mục đích: gửi một mục lưu bút.

GET /api/v1/reviews
Mục đích: đọc các đánh giá đã được phép công khai.

POST /api/v1/reviews
Mục đích: gửi đánh giá hoặc phản hồi theo chính sách hệ thống.

Các endpoint gửi nội dung phải có validation và biện pháp hạn chế spam.

## 8. Tài khoản và hồ sơ

POST /api/v1/auth/register
Mục đích: đăng ký tài khoản.

POST /api/v1/auth/login
Mục đích: đăng nhập.

POST /api/v1/auth/logout
Mục đích: đăng xuất.

GET /api/v1/me
Quyền: cần đăng nhập.
Mục đích: xem thông tin tài khoản hiện tại.

PATCH /api/v1/me
Quyền: cần đăng nhập.
Mục đích: cập nhật những trường hồ sơ được phép.

Cơ chế session hoặc token phải được chọn ở giai đoạn khởi tạo
Backend, căn cứ topology triển khai và yêu cầu bảo mật.
Không đồng thời triển khai nhiều cơ chế xác thực không cần thiết.

## 9. Bộ sưu tập cá nhân

GET /api/v1/me/favorites/artifacts
Quyền: cần đăng nhập.
Mục đích: danh sách hiện vật yêu thích.

POST /api/v1/me/favorites/artifacts/{artifactId}
Quyền: cần đăng nhập.
Mục đích: thêm hiện vật vào yêu thích.

DELETE /api/v1/me/favorites/artifacts/{artifactId}
Quyền: cần đăng nhập.
Mục đích: xóa hiện vật khỏi yêu thích.

GET /api/v1/me/favorites/tours
Quyền: cần đăng nhập.
Mục đích: danh sách tour yêu thích.

POST /api/v1/me/favorites/tours/{tourId}
Quyền: cần đăng nhập.
Mục đích: thêm tour vào yêu thích.

DELETE /api/v1/me/favorites/tours/{tourId}
Quyền: cần đăng nhập.
Mục đích: xóa tour khỏi yêu thích.

## 10. Phiên tham quan và sự kiện

POST /api/v1/visits
Mục đích: khởi tạo phiên tham quan.

Dữ liệu dự kiến:
- visit_mode: free hoặc guided.
- tour_id: bắt buộc đối với phiên guided, theo quy tắc nghiệp vụ.
- tùy chọn thông tin điểm bắt đầu hợp lệ.

POST /api/v1/visits/{publicId}/events
Mục đích: ghi nhận sự kiện tham quan.

Sự kiện có thể gồm:
- viewpoint_opened.
- gateway_selected.
- hotspot_opened.
- artifact_viewed.
- narration_started.
- tour_stop_completed.

POST /api/v1/visits/{publicId}/stops/{tourStopId}/complete
Mục đích: ghi nhận hoàn thành điểm dừng.

POST /api/v1/visits/{publicId}/finish
Mục đích: hoàn thành phiên tham quan.

Các endpoint này phải kiểm tra dữ liệu, trạng thái phiên,
giới hạn tần suất và tính hợp lệ của điểm dừng.
publicId không thay thế kiểm soát quyền truy cập.

## 11. API quản trị

Tất cả endpoint dưới đây yêu cầu quyền quản trị phù hợp.

### Hiện vật

GET    /api/v1/admin/artifacts
POST   /api/v1/admin/artifacts
GET    /api/v1/admin/artifacts/{artifactId}
PATCH  /api/v1/admin/artifacts/{artifactId}
DELETE /api/v1/admin/artifacts/{artifactId}

### Không gian

GET    /api/v1/admin/spaces
POST   /api/v1/admin/spaces
PATCH  /api/v1/admin/spaces/{spaceId}
DELETE /api/v1/admin/spaces/{spaceId}

### Điểm nhìn

POST   /api/v1/admin/viewpoints
PATCH  /api/v1/admin/viewpoints/{viewpointId}
DELETE /api/v1/admin/viewpoints/{viewpointId}

### Gateway

POST   /api/v1/admin/gateways
PATCH  /api/v1/admin/gateways/{gatewayId}
DELETE /api/v1/admin/gateways/{gatewayId}

### Hotspot

POST   /api/v1/admin/hotspots
PATCH  /api/v1/admin/hotspots/{hotspotId}
DELETE /api/v1/admin/hotspots/{hotspotId}

### Tour

GET    /api/v1/admin/tours
POST   /api/v1/admin/tours
PATCH  /api/v1/admin/tours/{tourId}
DELETE /api/v1/admin/tours/{tourId}

POST   /api/v1/admin/tours/{tourId}/stops
PATCH  /api/v1/admin/tours/{tourId}/stops/{stopId}
DELETE /api/v1/admin/tours/{tourId}/stops/{stopId}

### Tài khoản và kiểm duyệt

GET   /api/v1/admin/users
PATCH /api/v1/admin/users/{userId}/status
GET   /api/v1/admin/reviews
PATCH /api/v1/admin/reviews/{reviewId}/moderation
GET   /api/v1/admin/guestbook
PATCH /api/v1/admin/guestbook/{entryId}/moderation

### Thống kê

GET /api/v1/admin/statistics/overview
GET /api/v1/admin/statistics/artifacts
GET /api/v1/admin/statistics/tours
GET /api/v1/admin/statistics/visits
GET /api/v1/admin/statistics/drop-offs

Endpoint drop-offs chỉ có ý nghĩa khi hệ thống đã có đủ sự kiện
và quy tắc xác định phiên bỏ dở.

## 12. Ví dụ cấu trúc dữ liệu scene

{
  "data": {
    "id": 101,
    "title": "Phòng trưng bày mẫu",
    "space": {
      "id": 12,
      "name": "Khu vực chính"
    },
    "panorama": {
      "url": "/media/panorama/example.jpg",
      "rendering_mode": "equirectangular",
      "tile_manifest_url": null
    },
    "initial_view": {
      "yaw_deg": 0,
      "pitch_deg": 0
    },
    "mini_map": {
      "x_norm": 0.5,
      "y_norm": 0.5
    },
    "gateways": [],
    "hotspots": []
  }
}

Đây là ví dụ về cấu trúc dự kiến, không phải dữ liệu thực.
URL media trong ví dụ phải được thay bằng URL do Backend
cung cấp khi triển khai thật.

## 13. Quy tắc phân quyền

- API công khai chỉ trả nội dung được xuất bản.
- API hồ sơ và yêu thích cần xác thực.
- API quản trị phải kiểm tra quyền tại máy chủ.
- Không dựa vào việc ẩn nút trên giao diện để bảo vệ API.
- Không cho người dùng sửa ID chủ sở hữu nhằm thao tác dữ liệu
  của người khác.
- Thao tác nhạy cảm phải được ghi log theo chính sách bảo mật.

## 14. Quy tắc thống nhất giữa Frontend và Backend

- Tên trường JSON phải nhất quán.
- ID và slug phải có ý nghĩa rõ ràng.
- Các trường nullable phải được quy định.
- Phân trang phải sử dụng một định dạng thống nhất.
- Ngày giờ phải trả về theo định dạng chuẩn và có quy ước múi giờ.
- Lỗi validation phải cho biết trường nào không hợp lệ.
- API không trả dữ liệu nội bộ không cần thiết.
- Thay đổi API phải cập nhật tài liệu và test liên quan.

## 15. Trạng thái tài liệu

Tài liệu này là hợp đồng API thiết kế ban đầu.
Trong quá trình triển khai, thay đổi phải được cập nhật ở đây
trước khi Frontend và Backend cùng sử dụng hợp đồng mới.
