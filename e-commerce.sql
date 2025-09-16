
Enum "Orders_status_enum" {
  "pending"
  "shipped"
  "delivered"
  "cancelled"
}

Enum "Payments_payment_method_enum" {
  "UPI"
  "Credit Card"
  "Debit Card"
  "Net Banking"
  "COD"
}

Enum "Payments_payment_status_enum" {
  "success"
  "failed"
  "pending"
}

Enum "Shipping_status_enum" {
  "shipped"
  "in_transit"
  "delivered"
  "delayed"
}

Enum "Product_Returns_status_enum" {
  "requested"
  "approved"
  "rejected"
  "refunded"
}

Enum "Help_Center_status_enum" {
  "open"
  "in_progress"
  "resolved"
  "closed"
}

Enum "Subscriptions_status_enum" {
  "active"
  "paused"
  "expired"
  "cancelled"
}

Enum "Subscriptions_payment_method_enum" {
  "UPI"
  "Credit Card"
  "Debit Card"
  "Net Banking"
  "COD"
}

Table "Customers" {
  "customer_id" INT [pk, increment]
  "first_name" VARCHAR(100)
  "last_name" VARCHAR(100)
  "email" VARCHAR(150) [unique, not null]
  "phone" VARCHAR(20)
  "password" VARCHAR(255) [not null]
  "address" VARCHAR(255)
  "city" VARCHAR(100)
  "state" VARCHAR(100)
  "pincode" VARCHAR(20)
  "country" VARCHAR(100)
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Sellers" {
  "seller_id" INT [pk, increment]
  "seller_name" VARCHAR(150) [not null]
  "email" VARCHAR(150) [unique, not null]
  "phone" VARCHAR(20)
  "password" VARCHAR(255) [not null]
  "business_name" VARCHAR(200)
  "business_address" VARCHAR(255)
  "gst_number" VARCHAR(50)
  "bank_account_details" VARCHAR(200)
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Categories" {
  "category_id" INT [pk, increment]
  "category_name" VARCHAR(100) [not null]
  "description" TEXT
  "parent_id" INT
  "image_url" VARCHAR(255)
  "is_active" BOOLEAN [default: TRUE]
  "display_order" INT [default: 0]
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Products" {
  "product_id" INT [pk, increment]
  "name" VARCHAR(200) [not null]
  "description" TEXT
  "price" DECIMAL(10,2) [not null]
  "stock_quantity" INT [default: 0]
  "category_id" INT
  "seller_id" INT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Orders" {
  "order_id" INT [pk, increment]
  "customer_id" INT
  "order_date" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "total_amount" DECIMAL(10,2) [not null]
  "status" Orders_status_enum [default: 'pending']
  "shipping_address" VARCHAR(255)
}

Table "Cart" {
  "cart_id" INT [pk, increment]
  "customer_id" INT
  "product_id" INT
  "quantity" INT [default: 1]
  "added_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Payments" {
  "payment_id" INT [pk, increment]
  "order_id" INT
  "payment_date" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "amount" DECIMAL(10,2) [not null]
  "payment_method" Payments_payment_method_enum [not null]
  "payment_status" Payments_payment_status_enum [default: 'pending']
}

Table "Reviews" {
  "review_id" INT [pk, increment]
  "customer_id" INT
  "product_id" INT
  "rating" INT
  "comment" TEXT
  "review_date" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Shipper_Partners" {
  "shipper_id" INT [pk, increment]
  "shipper_name" VARCHAR(150) [not null]
  "contact_number" VARCHAR(20)
  "email" VARCHAR(150)
  "address" VARCHAR(255)
}

Table "Shipping" {
  "shipping_id" INT [pk, increment]
  "order_id" INT
  "shipper_id" INT
  "tracking_number" VARCHAR(100)
  "shipping_date" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "delivery_date" TIMESTAMP
  "status" Shipping_status_enum [default: 'shipped']
}

Table "Cancellations" {
  "cancellation_id" INT [pk, increment]
  "order_id" INT
  "customer_id" INT
  "reason" VARCHAR(255)
  "cancelled_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Product_Returns" {
  "return_id" INT [pk, increment]
  "order_id" INT
  "product_id" INT
  "customer_id" INT
  "reason" VARCHAR(255)
  "return_date" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "status" Product_Returns_status_enum [default: 'requested']
}

Table "Wishlist" {
  "wishlist_id" INT [pk, increment]
  "customer_id" INT
  "product_id" INT
  "added_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Help_Center" {
  "ticket_id" INT [pk, increment]
  "customer_id" INT
  "subject" VARCHAR(255)
  "message" TEXT
  "status" Help_Center_status_enum [default: 'open']
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "Subscriptions" {
  "subscription_id" INT [pk, increment]
  "customer_id" INT
  "subscription_name" VARCHAR(150) [not null]
  "start_date" DATE [not null]
  "end_date" DATE
  "status" Subscriptions_status_enum [default: 'active']
  "price" DECIMAL(10,2) [not null]
  "payment_method" Subscriptions_payment_method_enum [not null]
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Ref:"Categories"."category_id" < "Categories"."parent_id"

Ref:"Categories"."category_id" < "Products"."category_id"

Ref:"Sellers"."seller_id" < "Products"."seller_id"

Ref:"Customers"."customer_id" < "Orders"."customer_id"

Ref:"Customers"."customer_id" < "Cart"."customer_id"

Ref:"Products"."product_id" < "Cart"."product_id"

Ref:"Orders"."order_id" < "Payments"."order_id"

Ref:"Customers"."customer_id" < "Reviews"."customer_id"

Ref:"Products"."product_id" < "Reviews"."product_id"

Ref:"Orders"."order_id" < "Shipping"."order_id"

Ref:"Shipper_Partners"."shipper_id" < "Shipping"."shipper_id"

Ref:"Orders"."order_id" < "Cancellations"."order_id"

Ref:"Customers"."customer_id" < "Cancellations"."customer_id"

Ref:"Orders"."order_id" < "Product_Returns"."order_id"

Ref:"Products"."product_id" < "Product_Returns"."product_id"

Ref:"Customers"."customer_id" < "Product_Returns"."customer_id"

Ref:"Customers"."customer_id" < "Wishlist"."customer_id"

Ref:"Products"."product_id" < "Wishlist"."product_id"

Ref:"Customers"."customer_id" < "Help_Center"."customer_id"

Ref:"Customers"."customer_id" < "Subscriptions"."customer_id"
