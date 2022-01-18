<?php
class proxy{
	function curl($url){ //Khai báo hàm và các tham số truyền vào
		$curl = curl_init(); // Khởi tạo
		curl_setopt ($curl, CURLOPT_URL, $url); // Chỉ định địa chỉ lấy dữ liệu
		curl_setopt ($curl, CURLOPT_TIMEOUT, 300); // Thiết lập timeout
		curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));// Giả tên trình duyệt
		curl_setopt ($curl, CURLOPT_HEADER,0); // Có kèm header của HTTP Reponse trong nội dung phản hồi ko
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1); // Tham số bổ sung
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);// Tham số bổ sung, ko xác nhận chứng chì ssl
		curl_setopt ($curl, CURLOPT_ENCODING, 'gzip,deflate');
		$html = curl_exec ($curl); // Bắt đầu lấy dữ liệu đưa vào biến $html
		curl_close ($curl); //Đóng kết nối
		return $html;//Trả về giá trị lấy dc
	}
}