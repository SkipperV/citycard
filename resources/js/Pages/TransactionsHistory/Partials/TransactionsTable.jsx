export default function TransactionsTable({transactions}) {
    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg rounded dark:border dark:border-gray-600">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead
                    className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3 w-1/2">Дата, час</th>
                    <th scope="col" className="px-6 py-3 w-1/2">Зміна балансу</th>
                </tr>
                </thead>
                <tbody>
                {transactions.map((transaction) =>
                    <tr key={transaction.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {transaction.created_at}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {transaction.transaction_type ? "+" : "-"}{transaction.balance_change}
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
        </div>
    );
}
