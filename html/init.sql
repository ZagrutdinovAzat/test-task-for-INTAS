USE mydatabase;

CREATE TABLE IF NOT EXISTS regions (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       name VARCHAR(255) NOT NULL,
    travel_time INT NOT NULL
    );

CREATE TABLE IF NOT EXISTS couriers (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        name VARCHAR(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS trips (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     region_id INT NOT NULL,
                                     courier_id INT NOT NULL,
                                     departure_date DATE NOT NULL,
                                     arrival_date DATE NOT NULL,
                                     FOREIGN KEY (region_id) REFERENCES regions(id),
    FOREIGN KEY (courier_id) REFERENCES couriers(id)
    );

INSERT INTO regions (name, travel_time) VALUES
                                            ('Saint Petersburg', 2),
                                            ('Ufa', 3),
                                            ('Nizhny Novgorod', 1),
                                            ('Vladimir', 1),
                                            ('Kostroma', 2),
                                            ('Yekaterinburg', 4),
                                            ('Kovrov', 1),
                                            ('Voronezh', 2),
                                            ('Samara', 3),
                                            ('Astrakhan', 4);

INSERT INTO couriers (name) VALUES
                                ('Ivanov Ivan Ivanovich'),
                                ('Petrov Peter Petrovich'),
                                ('Sidorov Sidor Sidorovich'),
                                ('Kuznetsov Kuzma Kuzmich'),
                                ('Smirnov Sergey Sergeevich'),
                                ('Popov Pavel Pavlovich'),
                                ('Vasiliev Vasily Vasilyevich'),
                                ('Mikhailov Mikhail Mikhailovich'),
                                ('Novikov Nikolai Nikolaevich'),
                                ('Fedorov Fyodor Fedorovich');
