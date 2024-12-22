import {Link, router} from "@inertiajs/react";
import {useTranslation} from "react-i18next";

export default function TransportTable({transports, cityId}) {
    const {t} = useTranslation()

    const deleteTransport = (id) => {
        router.delete(route('transport.destroy', [cityId, id]));
    }

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3">{t("transport.table.route_number")}</th>
                    <th scope="col" className="px-6 py-3">{t("transport.table.transport_type")}</th>
                    <th scope="colgroup" className="pl-6 py-3 w-auto col-span-2">{t("transport.table.endpoints")}</th>
                    <th scope="col" className="px-6 py-3"></th>
                    <th scope="col" className="px-6 py-3">{t("operations.edit")}</th>
                    <th scope="col" className="px-6 py-3">{t("operations.delete")}</th>
                </tr>
                </thead>
                <tbody>
                {transports.map((transportRoute) =>
                    <tr key={transportRoute.id} className="bg-white border-t dark:bg-gray-900 dark:border-gray-700">
                        <td scope="col" className="px-6 py-4">
                            {transportRoute.route_number}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {t(`transport.type.${transportRoute.transport_type}`)}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {transportRoute.route_endpoint_1}
                        </td>
                        <td scope="col" className="px-6 py-4">
                            {transportRoute.route_endpoint_2}
                        </td>
                        <td className="px-6 py-4">
                            <Link href={route('transport.edit', [cityId, transportRoute.id])}
                                  className="font-medium text-green-700 dark:text-green-600 hover:underline">
                                {t(`operations.edit`)}
                            </Link>
                        </td>
                        <td scope="col" className="px-6 py-4">
                            <button onClick={() => deleteTransport(transportRoute.id)}
                                    className="text-red-600 font-medium">
                                {t(`operations.delete`)}
                            </button>
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
        </div>
    );
}
