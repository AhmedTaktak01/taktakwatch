import pulp

def solve_production_problem():
    print("\n" + "="*50)
    print(" LINEAR PROGRAMMING OPTIMIZER")
    print(" Maximize profit with limited resources")
    print("="*50)
    
    # Get resources (materials)
    print("\n📦 STEP 1: Enter your available resources")
    resources = []
    resource_names = []
    num_resources = int(input("How many different materials do you have? "))
    
    for i in range(num_resources):
        name = input(f"  Material {i+1} name: ")
        qty = float(input(f"  Available quantity of {name}: "))
        resources.append(qty)
        resource_names.append(name)
    
    # Get products
    print("\n🍬 STEP 2: Enter your products")
    product_names = []
    profits = []
    num_products = int(input("How many different products can you make? "))
    
    for i in range(num_products):
        name = input(f"  Product {i+1} name: ")
        profit = float(input(f"  Profit per unit of {name} ($): "))
        product_names.append(name)
        profits.append(profit)
    
    # Get recipe (how much of each material per product)
    print("\n📊 STEP 3: Enter the recipe (materials needed per product)")
    recipe = []
    for i in range(num_resources):
        row = []
        print(f"\n  For material: {resource_names[i]}")
        for j in range(num_products):
            amount = float(input(f"    How many {resource_names[i]} needed for 1 unit of {product_names[j]}? "))
            row.append(amount)
        recipe.append(row)
    
    # Create the optimization problem
    prob = pulp.LpProblem("Production_Optimization", pulp.LpMaximize)
    
    # Decision variables (how many of each product to make)
    prod_vars = [pulp.LpVariable(f"make_{product_names[i]}", lowBound=0) for i in range(num_products)]
    
    # Objective: maximize total profit
    prob += pulp.lpSum([profits[i] * prod_vars[i] for i in range(num_products)])
    
    # Constraints: don't use more resources than available
    for i in range(num_resources):
        prob += pulp.lpSum([recipe[i][j] * prod_vars[j] for j in range(num_products)]) <= resources[i]
    
    # Solve
    print("\n" + "="*50)
    print("🔍 SOLVING...")
    print("="*50)
    
    prob.solve(pulp.PULP_CBC_CMD(msg=False))
    
    # Display results
    if pulp.LpStatus[prob.status] == "Optimal":
        print("\n✅ OPTIMAL SOLUTION FOUND!\n")
        
        total_profit = 0
        print("📋 PRODUCTION PLAN:")
        print("-" * 40)
        for i in range(num_products):
            qty = pulp.value(prod_vars[i])
            total_profit += qty * profits[i]
            print(f"  • Make {qty:.2f} units of {product_names[i]} → profit: ${qty * profits[i]:.2f}")
        
        print("-" * 40)
        print(f"💰 TOTAL MAXIMUM PROFIT: ${total_profit:.2f}")
        
        print("\n📦 RESOURCE USAGE:")
        print("-" * 40)
        for i in range(num_resources):
            used = sum(recipe[i][j] * pulp.value(prod_vars[j]) for j in range(num_products))
            print(f"  • {resource_names[i]}: used {used:.2f} / available {resources[i]:.2f} (remaining: {resources[i] - used:.2f})")
        
    else:
        print("\n❌ No optimal solution found. Check your constraints!")
        print(f"   Status: {pulp.LpStatus[prob.status]}")
    
    print("\n" + "="*50)

# Run the calculator
if __name__ == "__main__":
    solve_production_problem()
    
    # Ask if user wants to run another scenario
    while True:
        again = input("\n🔁 Run another scenario? (yes/no): ").lower()
        if again == "yes" or again == "y":
            solve_production_problem()
        else:
            print("\n👋 Goodbye!")
            break