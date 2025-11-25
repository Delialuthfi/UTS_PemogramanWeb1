CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    founded_year INT NOT NULL,
    employees INT NOT NULL,
    website VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO companies (name, category, description, image_url, founded_year, employees, website) VALUES
('Google LLC', 'Technology', 'Google adalah perusahaan teknologi multinasional Amerika yang berspesialisasi dalam layanan dan produk terkait Internet, termasuk teknologi iklan online, mesin pencari, komputasi awan, perangkat lunak, dan perangkat keras.', 'https://images.unsplash.com/photo-1573804633927-bfcbcd909acd?w=800', 1998, 150000, 'https://google.com'),
('Microsoft Corporation', 'Software', 'Microsoft adalah perusahaan teknologi multinasional yang mengembangkan, memproduksi, melisensikan, mendukung, dan menjual perangkat lunak komputer, elektronik konsumen, komputer pribadi, dan layanan terkait.', 'https://images.unsplash.com/photo-1633419461186-7d40a38105ec?w=800', 1975, 220000, 'https://microsoft.com'),
('Apple Inc', 'Electronics', 'Apple adalah perusahaan teknologi multinasional Amerika yang merancang, mengembangkan, dan menjual elektronik konsumen, perangkat lunak komputer, dan layanan online.', 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=800', 1976, 164000, 'https://apple.com'),
('Amazon.com Inc', 'E-commerce', 'Amazon adalah perusahaan teknologi multinasional Amerika yang berfokus pada e-commerce, komputasi awan, streaming digital, dan kecerdasan buatan.', 'https://images.unsplash.com/photo-1523474253046-8cd2748b5fd2?w=800', 1994, 1540000, 'https://amazon.com'),
('Meta Platforms', 'Social Media', 'Meta adalah konglomerat teknologi multinasional Amerika yang memiliki dan mengoperasikan Facebook, Instagram, WhatsApp, dan platform media sosial lainnya.', 'https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=800', 2004, 86000, 'https://meta.com'),
('Tesla Inc', 'Automotive', 'Tesla adalah perusahaan kendaraan listrik dan energi bersih Amerika yang merancang dan memproduksi mobil listrik, penyimpanan baterai, dan produk tenaga surya.', 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800', 2003, 127855, 'https://tesla.com');