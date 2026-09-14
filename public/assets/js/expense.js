function ExpenseViewModel(initialExpenses,csrfTokenKey,csrfToken){
    const self=this;
    self.csrfTokenKey = csrfTokenKey;
    self.csrfToken    = csrfToken;

    function wrap(e){
        return {
            id:e.id,
            title:ko.observable(e.title),
            amount:ko.observable(Number(e.amount)),
            category_id:ko.observable(e.category_id),
            category_name:ko.observable(e.category_name),
            expense_date:ko.observable(e.expense_date),
            memo:ko.observable(e.memo),
            isEditing:ko.observable(false)
        };
    }

    self.expenses = ko.observableArray(initialExpenses.map(wrap));

    function readCsrfCookie(name){
        const match = document.cookie.match(new RegExp("(?:^|; )"+name+"=([^;]*)"));
        return match ? decodeURIComponent(match[1]):null;
    }


    function postForm(url,data){
        const params = new URLSearchParams();
        for (let key in data){
            params.append(key,data[key])
        };
        params.append(self.csrfTokenKey,self.csrfToken);

        return fetch(url,{
            method:"POST",
            headers:{
                "X-Requested-With":"XMLHttpRequest",
                "Content-Type":"application/x-www-form-urlencoded"
            },
            body:params.toString()
        }).then(function(res){
            const fresh = readCsrfCookie(self.csrfTokenKey);
            if(fresh){
                self.csrfToken=fresh;
            }
            if(!res.ok){
                throw new Error("リクエストに失敗しました。もう一度お試しください。");
            }
            return res.json();
        })
    }
    self.startEdit  = function(item){item.isEditing(true);};
    self.cancelEdit = function(item){item.isEditing(false);};
    self.saveEdit   = function(item){
        postForm("/expense/"+item.id+"/edit",{
            title:item.title(),
            amount:item.amount(),
            category_id:item.category_id(),
            expense_date:item.expense_date(),
            memo:item.memo(),
        }).then(function(res){
            if(!res.success){
                alert(res.errors.join("\n"));
                return;
            }
            item.title(res.expense.title);
            item.amount(res.expense.amount);
            item.category_name(res.expense.category_name);
            item.expense_date(res.expense.expense_date);
            item.memo(res.expense.memo);
            item.isEditing(false);
        });
    };
    self.deleteExpense = function(item){
        if (!confirm("削除しますか？")){
            return;
        }
        postForm("/expense/"+item.id+"/delete",{}).then(function(res){
            if(res.success){
                self.expenses.remove(item);
            }
        });
    };
}