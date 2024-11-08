/**
 * @Author: Your name
 * @Date:   2024-11-08 22:50:08
 * @Last Modified by:   Your name
 * @Last Modified time: 2024-11-08 23:39:59
 */
const mysql = require('mysql2/promise');

exports.handler = async (event) => {
  try {
    // Kiểm tra method request
    if (event.httpMethod !== 'POST') {
      return {
        statusCode: 405,
        body: JSON.stringify({ error: 'Method Not Allowed' }),
      };
    }

    // Parse dữ liệu từ body
    const { email, password } = JSON.parse(event.body);

    // Kiểm tra dữ liệu đầu vào
    if (!email || !password) {
      return {
        statusCode: 400,
        body: JSON.stringify({ error: 'Email và mật khẩu là bắt buộc' }),
      };
    }

    // Kết nối đến database MySQL
    const connection = await mysql.createConnection({
      host: process.env.MYSQL_HOST,
      user: process.env.MYSQL_USER,
      password: process.env.MYSQL_PASSWORD,
      database: process.env.MYSQL_DATABASE,
    });

    // Kiểm tra xem email đã tồn tại chưa
    const [rows] = await connection.execute('SELECT * FROM users WHERE email = ?', [email]);
    if (rows.length > 0) {
      await connection.end();
      return {
        statusCode: 400,
        body: JSON.stringify({ error: 'Email đã tồn tại' }),
      };
    }

    // Thêm người dùng mới
    await connection.execute('INSERT INTO users (email, password) VALUES (?, ?)', [email, password]);
    await connection.end();

    // Trả về kết quả JSON hợp lệ
    return {
      statusCode: 200,
      body: JSON.stringify({ message: 'Đăng ký thành công' }),
    };
  } catch (error) {
    // Xử lý lỗi và trả về JSON
    return {
      statusCode: 500,
      body: JSON.stringify({ error: error.toString() }),
    };
  }
};
