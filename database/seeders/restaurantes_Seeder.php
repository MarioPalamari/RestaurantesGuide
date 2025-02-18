<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use Illuminate\Database\Seeder;

class restaurantes_Seeder extends Seeder
{
    public function run(): void
    {
        $restaurantes = [
            [
                'nombre' => 'La Parrilla',
                'descripcion' => 'En La Parrilla, nos enorgullecemos de ofrecer una experiencia culinaria centrada en las carnes de la más alta calidad. Nuestros cortes premium de ternera Angus, cerdo ibérico y cordero patagónico son seleccionados cuidadosamente por nuestros expertos carniceros. Utilizamos técnicas tradicionales argentinas, con brasas de leña de quebracho que aportan un sabor ahumado único. Nuestro menú incluye desde clásicos como el bife de chorizo y las costillas BBQ hasta creaciones propias como el lomo al chimichurri. El ambiente rústico, con decoración de campo y mesas de madera maciza, te transportará a las estancias pampeanas. Además, contamos con una amplia selección de vinos tintos de bodegas argentinas para maridar perfectamente con tus platos.',
                'precio_medio' => 25.50,
                'img' => 'parrilla.jpg',
                'lugar' => 'Carrer de Salamanca, 1, Ciutat Vella, 08003 Barcelona',
                'horario' => '9:00 - 21:00',
                'contacto' => '692953216',
                'web' => 'https://www.thefork.es/'
            ],
            [
                'nombre' => 'Sushi Master',
                'descripcion' => 'Sushi Master es un santuario para los amantes de la auténtica cocina japonesa. Nuestro pescado es importado diariamente desde el famoso mercado de Tsukiji en Tokio, garantizando frescura y calidad suprema. Contamos con chefs japoneses certificados que dominan técnicas tradicionales como el nigiri, sashimi y maki, además de crear rolls innovadores con toques contemporáneos. Nuestro menú incluye desde clásicos como el toro y el uni hasta creaciones exclusivas como el rollo trufado con foie gras. El ambiente minimalista, con decoración inspirada en los ryokan tradicionales y una barra de sushi de madera de ciprés, te sumerge en la cultura japonesa. También ofrecemos una selección premium de sake y té matcha de Uji.',
                'precio_medio' => 30.00,
                'img' => 'sushi.jpg',
                'lugar' => 'Ctra. de Pozuelo, 48, 28222 Majadahonda, Madrid',
                'horario' => '9:00 - 21:00',
                'contacto' => '910164431',
                'web' => 'https://www.sushimaster.net/'
            ],
            [
                'nombre' => 'Pizza Italiana',
                'descripcion' => 'En Pizza Italiana, mantenemos viva la tradición napolitana con cada pizza que sale de nuestro horno de leña. Nuestra masa madre, cultivada durante más de 20 años, se combina con ingredientes importados directamente de Italia: mozzarella di bufala de Campania, tomates San Marzano de las laderas del Vesubio y aceite de oliva virgen extra de la Toscana. Nuestros pizzaiolos, formados en la Associazione Verace Pizza Napoletana, dominan el arte de estirar la masa a mano y cocinarla a la perfección en 90 segundos. Desde la clásica Margherita hasta creaciones gourmet como la pizza con trufa negra y prosciutto di Parma, cada bocado es un viaje a Italia. El ambiente acogedor, con mesas de mármol y paredes decoradas con fotos vintage de Nápoles, completa la experiencia.',
                'precio_medio' => 15.75,
                'img' => 'pizza.jpg',
                'lugar' => "Pizza Energia, Carrer de l'Arquitectura, 32, 08908 L'Hospitalet de Llobregat, Barcelona",
                'horario' => '9:00 - 21:00',
                'contacto' => '933321245',
                'web' => 'http://pizzaenergia.es/'
            ],
            [
                'nombre' => 'Burger House',
                'descripcion' => 'Burger House redefine el concepto de hamburguesería gourmet con ingredientes de primera calidad y combinaciones innovadoras. Nuestra carne 100% Angus proviene de ganado alimentado con pasto, y ofrecemos opciones como wagyu australiano y bisonte americano. Los panes son artesanales, horneados diariamente con masa madre y semillas de sésamo tostadas. Nuestro menú incluye desde clásicos como la cheeseburger con cheddar ahumado hasta creaciones exclusivas como la truffle burger con foie gras y reducción de oporto. También contamos con opciones vegetarianas y veganas, como nuestra famosa Beyond Burger con queso de anacardos. El ambiente industrial-chic, con luces de neón y música retro, crea un espacio vibrante y moderno. Además, nuestra selección de cervezas artesanales locales marida perfectamente con nuestras burgers.',
                'precio_medio' => 12.99,
                'img' => 'burger.jpg',
                'lugar' => 'Carrer de Baltasar Oriol i Mercer, 68, 08940 Cornellà de Llobregat, Barcelona',
                'horario' => '9:00 - 21:00',
                'contacto' => '930232363',
                'web' => 'https://www.burguerhouse.com/'
            ],
            [
                'nombre' => 'Veggie World',
                'descripcion' => 'Veggie World es un paraíso para los amantes de la cocina vegetariana y vegana, donde la creatividad y los sabores internacionales se fusionan en cada plato. Utilizamos exclusivamente productos orgánicos de temporada, provenientes de granjas locales sostenibles. Nuestro menú cambia según las estaciones, ofreciendo desde bowls de superalimentos y ensaladas gourmet hasta platos principales innovadores como el risotto de hongos silvestres y el curry tailandés de calabaza. Nuestros chefs, expertos en técnicas como la fermentación y la cocina al vacío, transforman los vegetales en experiencias gastronómicas sorprendentes. El ambiente zen, con paredes verdes vivas y muebles de bambú, crea un espacio relajante y ecológico. También ofrecemos una amplia selección de jugos cold-pressed, tés orgánicos y vinos biodinámicos.',
                'precio_medio' => 18.50,
                'img' => 'veggie.jpg',
                'lugar' => 'Carrer de Bruniquer, 24, Gràcia, 08012 Barcelona',
                'horario' => '9:00 - 21:00',
                'contacto' => '932107056',
                'web' => 'https://www.vegworld.es/'
            ]
        ];

        foreach ($restaurantes as $restaurante) {
            Restaurante::create($restaurante);
        }
    }
}
