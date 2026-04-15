-- seed.sql
-- Inserindo um administrador e um cliente 
INSERT INTO usuarios (nome, email, senha, tipo) VALUES 
('Admin Geral', 'admin@locadora.com', '123456', 'admin'),
('Ricardo', 'ricardo@email.com', 'senha123', 'cliente');

-- Administrador inserindo carros top de luxo no sistema
INSERT INTO carros (marca, modelo, ano, placa, valor_diaria, status) VALUES 
('Porsche', '911 Carrera S', 2024, 'POR-0911', 3500.00, 'disponivel'),
('Ferrari', 'F8 Tributo', 2023, 'FER-0008', 8000.00, 'disponivel'),
('Rolls-Royce', 'Phantom', 2024, 'ROL-1000', 15000.00, 'manutencao');

-- Cliente (Ricardo, ID 2) alugando o Porsche 911 (ID 1) por 3 dias
-- Cálculo: 3 dias x R$ 3.500,00 = R$ 10.500,00
INSERT INTO locacoes (usuario_id, carro_id, data_inicio, data_fim, valor_total, status) VALUES 
(2, 1, '2026-05-10', '2026-05-13', 10500.00, 'ativa');

-- Atualizando o status do carro para "alugado" após a locação
UPDATE carros SET status = 'alugado' WHERE id = 1;