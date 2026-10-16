# MÔ HÌNH DỮ LIỆU DT-16

## 1. Quy ước chung

Tên bảng và tên cột dùng tiếng Anh, theo snake_case.
Tên bảng dùng số nhiều.
Khóa chính dự kiến dùng BIGINT UNSIGNED.
Khóa ngoại dùng cùng kiểu dữ liệu với khóa chính được tham chiếu.

Các bảng nghiệp vụ thường có:
- created_at
- updated_at

Những bảng cần quản lý xóa mềm sẽ được xem xét bổ sung deleted_at
trong giai đoạn triển khai migration.

Dữ liệu người dùng nhập phải được kiểm tra ở Backend.
Các URL media phải là URL hoặc đường dẫn lưu trữ tương đối,
không sử dụng đường dẫn tuyệt đối của máy lập trình.

## 2. Danh sách bảng

### 2.1. roles

Mục đích:
Lưu danh sách vai trò.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- code: VARCHAR(50), bắt buộc, duy nhất.
- name: VARCHAR(100), bắt buộc.
- description: TEXT, có thể null.
- created_at.
- updated_at.

Dữ liệu ban đầu:
- visitor
- admin

Có thể bổ sung curator hoặc content_manager nếu yêu cầu thực tế
cần vai trò trung gian.

### 2.2. users

Mục đích:
Lưu tài khoản người dùng.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- name: VARCHAR(150), bắt buộc.
- email: VARCHAR(255), bắt buộc, duy nhất.
- email_verified_at: TIMESTAMP, có thể null.
- password: VARCHAR, lưu mật khẩu đã băm, không lưu mật khẩu thuần.
- is_active: BOOLEAN, mặc định true.
- locked_at: TIMESTAMP, có thể null.
- remember_token: trường tương thích cơ chế Laravel nếu sử dụng.
- created_at.
- updated_at.

Quy tắc:
- Email phải duy nhất sau khi chuẩn hóa.
- Mật khẩu phải được băm bằng cơ chế chuyên dụng.
- Khóa tài khoản phải được kiểm tra ở Backend.

### 2.3. role_user

Mục đích:
Liên kết người dùng với vai trò.

Các trường:
- user_id: FK đến users.id.
- role_id: FK đến roles.id.
- created_at.
- updated_at.

Khóa:
- Khóa chính ghép (user_id, role_id).
- Không cho một người dùng được gán trùng cùng vai trò.

### 2.4. museums

Mục đích:
Quản lý các bảo tàng hoặc bộ sưu tập bảo tàng trong hệ thống.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- slug: VARCHAR(160), bắt buộc, duy nhất.
- name: VARCHAR(255), bắt buộc.
- institution: VARCHAR(255), có thể null.
- country_code: CHAR(2), có thể null.
- description: TEXT, có thể null.
- official_url: VARCHAR(2048), có thể null.
- is_published: BOOLEAN, mặc định false.
- created_at.
- updated_at.

Quy tắc:
Chỉ công khai dữ liệu được xuất bản.

### 2.5. media_assets

Mục đích:
Quản lý metadata của hình ảnh, panorama, audio và video.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- media_type: VARCHAR(30), bắt buộc.
- disk: VARCHAR(50), tên nơi lưu trữ.
- storage_path: VARCHAR(2048), đường dẫn tương đối.
- original_filename: VARCHAR(255), có thể null.
- mime_type: VARCHAR(150), bắt buộc.
- size_bytes: BIGINT UNSIGNED, có thể null.
- width_px: INT UNSIGNED, có thể null.
- height_px: INT UNSIGNED, có thể null.
- duration_ms: BIGINT UNSIGNED, có thể null.
- language_code: VARCHAR(10), có thể null.
- alt_text: VARCHAR(500), có thể null.
- license_name: VARCHAR(255), có thể null.
- source_url: VARCHAR(2048), có thể null.
- attribution_text: TEXT, có thể null.
- checksum_sha256: CHAR(64), có thể null.
- created_by: FK đến users.id, có thể null.
- created_at.
- updated_at.

Các loại media dự kiến:
- panorama
- image
- audio
- video

Quy tắc:
- Không lưu file lớn trực tiếp trong cột BLOB thông thường.
- Phải xác minh loại file, dung lượng và quyền truy cập.
- Tài nguyên sử dụng trong dự án phải có thông tin nguồn và giấy phép
  khi điều kiện sử dụng yêu cầu.
- storage_path không được chứa đường dẫn ổ C của máy lập trình.

### 2.6. spaces

Mục đích:
Quản lý không gian hoặc khu vực tham quan.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- museum_id: FK đến museums.id.
- parent_space_id: FK đến spaces.id, có thể null.
- slug: VARCHAR(160), bắt buộc.
- name: VARCHAR(255), bắt buộc.
- description: TEXT, có thể null.
- display_order: INT UNSIGNED, mặc định 0.
- is_published: BOOLEAN, mặc định false.
- created_at.
- updated_at.

Quy tắc:
- Một museum có nhiều space.
- Một space có thể có space con.
- slug phải duy nhất trong phạm vi museum.

### 2.7. viewpoints

Mục đích:
Lưu các điểm nhìn panorama 360°.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- space_id: FK đến spaces.id.
- slug: VARCHAR(160), bắt buộc.
- title: VARCHAR(255), bắt buộc.
- description: TEXT, có thể null.
- panorama_asset_id: FK đến media_assets.id.
- tile_manifest_asset_id: FK đến media_assets.id, có thể null.
- rendering_mode: VARCHAR(30), mặc định equirectangular.
- initial_yaw_deg: DECIMAL(8,4), mặc định 0.
- initial_pitch_deg: DECIMAL(8,4), mặc định 0.
- mini_map_x_norm: DECIMAL(8,6), có thể null.
- mini_map_y_norm: DECIMAL(8,6), có thể null.
- is_entry_point: BOOLEAN, mặc định false.
- display_order: INT UNSIGNED, mặc định 0.
- is_published: BOOLEAN, mặc định false.
- created_at.
- updated_at.

Quy tắc:
- Một space có nhiều viewpoint.
- Mỗi viewpoint có một panorama chính.
- tile_manifest_asset_id có thể null nếu chỉ dùng ảnh panorama đầy đủ.
- rendering_mode phải phù hợp với định dạng tài nguyên.
- Tọa độ MiniMap được chuẩn hóa trong khoảng 0 đến 1.

### 2.8. gateways

Mục đích:
Tạo các điểm chuyển từ viewpoint này sang viewpoint khác.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- from_viewpoint_id: FK đến viewpoints.id.
- to_viewpoint_id: FK đến viewpoints.id.
- label: VARCHAR(150), bắt buộc.
- yaw_deg: DECIMAL(8,4), bắt buộc.
- pitch_deg: DECIMAL(8,4), bắt buộc.
- target_yaw_deg: DECIMAL(8,4), có thể null.
- target_pitch_deg: DECIMAL(8,4), có thể null.
- display_order: INT UNSIGNED, mặc định 0.
- is_active: BOOLEAN, mặc định true.
- created_at.
- updated_at.

Quy tắc:
- Điểm nguồn và điểm đích phải tồn tại.
- Không hiển thị Gateway không hoạt động.
- Điểm đích phải có quyền truy cập hợp lệ.
- Tọa độ Gateway phải được kiểm tra ở Backend.

### 2.9. artifacts

Mục đích:
Quản lý thông tin hiện vật.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- museum_id: FK đến museums.id.
- slug: VARCHAR(180), bắt buộc.
- title: VARCHAR(255), bắt buộc.
- origin: VARCHAR(255), có thể null.
- period: VARCHAR(255), có thể null.
- material: VARCHAR(255), có thể null.
- description: TEXT, có thể null.
- source_name: VARCHAR(255), có thể null.
- source_url: VARCHAR(2048), có thể null.
- source_license: VARCHAR(255), có thể null.
- attribution_text: TEXT, có thể null.
- created_by: FK đến users.id, có thể null.
- is_published: BOOLEAN, mặc định false.
- created_at.
- updated_at.

Quy tắc:
- Mỗi artifact thuộc một museum.
- slug duy nhất trong phạm vi museum.
- Nội dung lịch sử/văn hóa phải có nguồn kiểm chứng.

### 2.10. artifact_media

Mục đích:
Liên kết hiện vật với một hoặc nhiều tài nguyên đa phương tiện.

Các trường:
- artifact_id: FK đến artifacts.id.
- media_asset_id: FK đến media_assets.id.
- media_role: VARCHAR(30), ví dụ cover, gallery, document.
- display_order: INT UNSIGNED, mặc định 0.
- created_at.
- updated_at.

Khóa:
- Khóa chính ghép (artifact_id, media_asset_id).

### 2.11. hotspots

Mục đích:
Đặt điểm tương tác trên viewpoint.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- viewpoint_id: FK đến viewpoints.id.
- artifact_id: FK đến artifacts.id, có thể null.
- title: VARCHAR(255), bắt buộc.
- description: TEXT, có thể null.
- hotspot_type: VARCHAR(30), bắt buộc.
- yaw_deg: DECIMAL(8,4), bắt buộc.
- pitch_deg: DECIMAL(8,4), bắt buộc.
- display_order: INT UNSIGNED, mặc định 0.
- is_active: BOOLEAN, mặc định true.
- created_at.
- updated_at.

Quy tắc:
- Một viewpoint có nhiều hotspot.
- Hotspot loại artifact phải có artifact hợp lệ.
- Hotspot thông tin có thể không cần liên kết artifact.
- yaw_deg và pitch_deg phải hợp lệ.
- Không hiển thị hotspot không hoạt động.

### 2.12. tours

Mục đích:
Quản lý tour tham quan theo chủ đề.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- museum_id: FK đến museums.id.
- slug: VARCHAR(180), bắt buộc.
- title: VARCHAR(255), bắt buộc.
- theme: VARCHAR(150), có thể null.
- description: TEXT, có thể null.
- estimated_duration_minutes: SMALLINT UNSIGNED, có thể null.
- cover_media_asset_id: FK đến media_assets.id, có thể null.
- created_by: FK đến users.id, có thể null.
- is_published: BOOLEAN, mặc định false.
- created_at.
- updated_at.

Quy tắc:
- Một museum có nhiều tour.
- slug duy nhất trong phạm vi museum.
- Chỉ tour đã xuất bản mới được hiển thị công khai.

### 2.13. tour_stops

Mục đích:
Lưu thứ tự điểm dừng của từng tour.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- tour_id: FK đến tours.id.
- viewpoint_id: FK đến viewpoints.id.
- sequence_no: INT UNSIGNED, bắt buộc.
- title_override: VARCHAR(255), có thể null.
- guidance_text: TEXT, có thể null.
- estimated_duration_minutes: SMALLINT UNSIGNED, có thể null.
- is_required: BOOLEAN, mặc định true.
- created_at.
- updated_at.

Quy tắc:
- Một tour có nhiều tour_stop.
- Mỗi tour_stop xác định một viewpoint.
- sequence_no duy nhất trong phạm vi tour.
- Thứ tự điểm dừng phải được trả đúng khi Frontend bắt đầu tour.

### 2.14. narrations

Mục đích:
Liên kết audio thuyết minh với nội dung hoặc điểm tham quan.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- language_code: VARCHAR(10), bắt buộc.
- title: VARCHAR(255), có thể null.
- transcript: TEXT, có thể null.
- audio_asset_id: FK đến media_assets.id.
- artifact_id: FK đến artifacts.id, có thể null.
- viewpoint_id: FK đến viewpoints.id, có thể null.
- tour_stop_id: FK đến tour_stops.id, có thể null.
- created_at.
- updated_at.

Quy tắc:
- Hỗ trợ tối thiểu mã ngôn ngữ vi và en khi có nội dung phù hợp.
- Mỗi bản ghi narration phải gắn đúng một mục tiêu:
  artifact, viewpoint hoặc tour_stop.
- Backend phải xác thực quy tắc mục tiêu trước khi lưu.
- Nếu thiếu audio của ngôn ngữ yêu cầu, API trả trạng thái phù hợp,
  không trả một đường dẫn tài nguyên không tồn tại.

### 2.15. favorite_artifacts

Mục đích:
Lưu các hiện vật yêu thích của người dùng.

Các trường:
- user_id: FK đến users.id.
- artifact_id: FK đến artifacts.id.
- created_at.

Khóa:
- Khóa chính ghép (user_id, artifact_id).

### 2.16. favorite_tours

Mục đích:
Lưu các tour yêu thích của người dùng.

Các trường:
- user_id: FK đến users.id.
- tour_id: FK đến tours.id.
- created_at.

Khóa:
- Khóa chính ghép (user_id, tour_id).

### 2.17. reviews

Mục đích:
Lưu đánh giá hoặc phản hồi về hiện vật/tour.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- user_id: FK đến users.id.
- artifact_id: FK đến artifacts.id, có thể null.
- tour_id: FK đến tours.id, có thể null.
- rating: TINYINT UNSIGNED, có thể null.
- content: TEXT, bắt buộc.
- moderation_status: VARCHAR(30), mặc định pending.
- created_at.
- updated_at.

Quy tắc:
- Mỗi review phải gắn với đúng một mục tiêu: artifact hoặc tour.
- Nếu có rating, giá trị từ 1 đến 5.
- Nội dung do người dùng gửi phải được kiểm tra.
- Chỉ hiển thị nội dung theo trạng thái kiểm duyệt.

### 2.18. guestbook_entries

Mục đích:
Lưu nội dung sổ lưu bút.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- user_id: FK đến users.id, có thể null.
- display_name: VARCHAR(150), có thể null.
- message: TEXT, bắt buộc.
- moderation_status: VARCHAR(30), mặc định pending.
- created_at.
- updated_at.

Quy tắc:
- Cho phép thiết kế hỗ trợ khách có tài khoản hoặc khách chưa đăng nhập,
  tùy chính sách được thống nhất.
- Nội dung chờ kiểm duyệt không hiển thị công khai.
- Không thu thập thêm dữ liệu cá nhân không cần thiết.

### 2.19. visit_sessions

Mục đích:
Theo dõi một phiên tham quan.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- public_id: UUID, bắt buộc, duy nhất.
- user_id: FK đến users.id, có thể null.
- tour_id: FK đến tours.id, có thể null.
- visit_mode: VARCHAR(30), free hoặc guided.
- status: VARCHAR(30), active, completed hoặc abandoned.
- started_at: TIMESTAMP, bắt buộc.
- ended_at: TIMESTAMP, có thể null.
- last_activity_at: TIMESTAMP, có thể null.
- last_viewpoint_id: FK đến viewpoints.id, có thể null.
- created_at.
- updated_at.

Quy tắc:
- Khách chưa đăng nhập có thể tạo phiên tham quan ẩn danh.
- Không dùng public_id để thay thế cơ chế kiểm soát quyền.
- Tiến trình chỉ được cập nhật theo quy tắc phiên hợp lệ.

### 2.20. visit_session_stops

Mục đích:
Theo dõi tiến độ tại các điểm dừng trong một phiên tour.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- visit_session_id: FK đến visit_sessions.id.
- tour_stop_id: FK đến tour_stops.id.
- status: VARCHAR(30), ví dụ not_started, in_progress,
  completed hoặc skipped.
- entered_at: TIMESTAMP, có thể null.
- completed_at: TIMESTAMP, có thể null.
- created_at.
- updated_at.

Quy tắc:
- Mỗi cặp visit_session_id và tour_stop_id chỉ có một bản ghi.
- Chỉ cho cập nhật điểm dừng thuộc tour của phiên tham quan.
- Thời điểm hoàn thành phải hợp lệ.

### 2.21. visit_events

Mục đích:
Lưu sự kiện tham quan để thống kê hành vi.

Các trường:
- id: BIGINT UNSIGNED, khóa chính.
- client_event_id: UUID, có thể null, duy nhất nếu có.
- visit_session_id: FK đến visit_sessions.id.
- event_type: VARCHAR(80), bắt buộc.
- viewpoint_id: FK đến viewpoints.id, có thể null.
- artifact_id: FK đến artifacts.id, có thể null.
- tour_id: FK đến tours.id, có thể null.
- event_data: JSON, có thể null.
- occurred_at: TIMESTAMP, bắt buộc.
- created_at.

Các event_type dự kiến:
- visit_started
- viewpoint_opened
- gateway_selected
- hotspot_opened
- artifact_viewed
- narration_started
- tour_stop_completed
- visit_completed
- visit_abandoned

Quy tắc:
- Không đưa mật khẩu, token hoặc dữ liệu nhạy cảm vào event_data.
- Dùng client_event_id khi cần chống ghi nhận sự kiện lặp.
- Không coi sự kiện thiếu dữ liệu là bằng chứng chắc chắn của việc bỏ dở.
- Cần quy tắc thời gian chờ và hoàn tất phiên trước khi tính tỷ lệ bỏ dở.

## 3. Quan hệ dữ liệu

- roles nhiều-nhiều users qua role_user.
- museums một-nhiều spaces.
- spaces có thể chứa spaces con.
- spaces một-nhiều viewpoints.
- viewpoints liên kết media_assets cho panorama.
- viewpoints một-nhiều gateways với tư cách điểm nguồn.
- viewpoints một-nhiều hotspots.
- artifacts nhiều-nhiều media_assets qua artifact_media.
- hotspots có thể liên kết một artifact.
- tours một-nhiều tour_stops.
- tour_stops liên kết viewpoint.
- narrations liên kết một artifact, viewpoint hoặc tour_stop.
- users nhiều-nhiều artifacts qua favorite_artifacts.
- users nhiều-nhiều tours qua favorite_tours.
- reviews liên kết user và đúng một artifact hoặc tour.
- guestbook_entries có thể liên kết user.
- visit_sessions có thể liên kết user và tour.
- visit_sessions một-nhiều visit_session_stops.
- visit_sessions một-nhiều visit_events.

## 4. Thứ tự tạo bảng dự kiến khi viết migration

1. users và roles.
2. role_user.
3. museums.
4. media_assets.
5. spaces.
6. viewpoints.
7. gateways.
8. artifacts.
9. artifact_media.
10. hotspots.
11. tours.
12. tour_stops.
13. narrations.
14. favorite_artifacts.
15. favorite_tours.
16. reviews.
17. guestbook_entries.
18. visit_sessions.
19. visit_session_stops.
20. visit_events.

Thứ tự cuối cùng cần được rà soát để mọi khóa ngoại trỏ tới bảng
đã tồn tại. Laravel migration sẽ được tạo trong Phần III,
không tạo thủ công bảng MySQL trong Phần II.

## 5. Quy tắc toàn vẹn dữ liệu

- Khóa ngoại phải được khai báo trong migration.
- Các cặp yêu thích phải duy nhất.
- Thứ tự tour_stop phải duy nhất trong một tour.
- Tài nguyên được tham chiếu phải tồn tại.
- Review chỉ được gắn vào một loại đối tượng.
- Narration chỉ được gắn vào một mục tiêu.
- Dữ liệu ẩn/không xuất bản không được trả ra API công khai.
- Thao tác xóa phải cân nhắc các dữ liệu lịch sử và khóa ngoại.
- Sự kiện tham quan không nên bị xóa tùy tiện nếu đã dùng trong thống kê.

## 6. Ghi chú triển khai

Đây là mô hình thiết kế ban đầu, chưa phải migration SQL.
Trước khi triển khai, cần kiểm tra kiểu dữ liệu, tên constraint,
các CHECK constraint và hành vi khóa ngoại trên phiên bản MySQL
được chọn.

Không tạo bảng bằng thao tác thủ công trong giao diện MySQL.
Schema chính thức sẽ được quản lý bằng Laravel migration.
