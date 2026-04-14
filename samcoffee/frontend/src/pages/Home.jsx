export default function Home() {
  return (
    <main className="max-w-6xl mx-auto px-6">

      {/* Welcome Section */}
      <section id="welcome" className="py-12 mb-8 border-b border-gray-200">
        <h2 className="text-center text-4xl text-coffee-brown mb-8">Welcome to Our Café</h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <img src="/images/Coffee-and-Pastries.jpg" alt="A cup of coffee and assorted pastries" className="w-full h-auto rounded-lg shadow-md" />
          <img src="/images/Cake-Vitrine.jpg" alt="A display case with various cakes" className="w-full h-auto rounded-lg shadow-md" />
          <img src="/images/Cookies.jpg" alt="A collection of freshly baked cookies" className="w-full h-auto rounded-lg shadow-md" />
          <img src="/images/Cup-of-Hot-Chocolate.jpg" alt="A warm cup of hot chocolate" className="w-full h-auto rounded-lg shadow-md" />
          <img src="/images/Strawberry-Tarts.jpg" alt="Fresh strawberry tarts" className="w-full h-auto rounded-lg shadow-md" />
          <img src="/images/Strawberry-Blueberry-Tarts.jpg" alt="Tarts with strawberries and blueberries" className="w-full h-auto rounded-lg shadow-md" />
        </div>
        <p className="text-lg text-gray-500 max-w-3xl mx-auto mt-8 text-center">
          Our café offers an assortment of delicious and delectable pastries and coffees that will put a smile on your face.
          From cookies to croissants, tarts and cakes, each treat is especially prepared to excite your tastebuds and brighten your day!
        </p>
      </section>

      {/* About Us Section */}
      <section id="about" className="py-12 mb-8 border-b border-gray-200">
        <h2 className="text-center text-4xl text-coffee-brown mb-8">About Us</h2>
        <div className="flex flex-wrap items-center gap-8">
          <img
            src="/images/SamKuoShop.jpg"
            alt="A picture of Sam Kuo's shop"
            className="max-w-sm w-full h-auto rounded-lg"
          />
          <p className="flex-1 min-w-72 text-lg text-gray-600">
            Sam has been adding sweetness to their customers' lives since 2025.
            Sam's recipes have been passed down from his mother and use simple and fresh ingredients
            to produce delightful flavors. He will personally greet you with a welcoming smile when you visit!
          </p>
        </div>
      </section>

      {/* Contact Us Section */}
      <section id="contact" className="py-12 mb-8">
        <h2 className="text-center text-4xl text-coffee-brown mb-8">Contact Us</h2>
        <div className="text-center text-lg text-gray-600">
          <img
            src="/images/Coffee-Shop.jpg"
            alt="The exterior of the coffee shop"
            className="rounded-lg mb-4 mx-auto"
            style={{ width: '150px', height: 'auto' }}
          />
          <p>
            321 Any Street<br />
            Any Town, New Zealand<br /><br />
            Tel: +64-21-027-933-55
          </p>
          <h3 className="mt-8 mb-2 text-2xl text-coffee-brown">Hours</h3>
          <p>
            Weekdays: 6:00am - 6:00pm<br />
            Saturday: 7:00am - 7:00pm<br />
            Closed on Sundays
          </p>
        </div>
      </section>

    </main>
  )
}
