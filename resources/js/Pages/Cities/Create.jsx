import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, router, useForm} from '@inertiajs/react';
import {useTranslation} from "react-i18next";

export default function Create({auth, status}) {
    const {t} = useTranslation()

    const handleRedirect = () => {
        router.visit(route('cities.index'));
    }

    const {data, setData, post, processing, errors} = useForm({
        region: '',
        name: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('cities.store'));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="relative w-full h-6">
                    <svg onClick={handleRedirect}
                         className="absolute left-3 top-1 h-4 text-gray-800 hover:cursor-pointer dark:text-white"
                         aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 8 14">
                        <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                              d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13"/>
                    </svg>
                    <h2 className="absolute left-1/2 transform -translate-x-1/2 top-0 h-full font-semibold text-xl text-gray-800 leading-tight dark:text-gray-300 text-center">
                        {t(`cities.title.create`)}
                    </h2>
                </div>
            }>
            <Head title={t(`cities.title.create`)}/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className="max-w-7xl mx-auto">
                <div className="w-96 mx-auto">
                    <form onSubmit={submit}>
                        <div className="mt-4">
                            <InputLabel htmlFor="region" className="dark:text-gray-300" value={t(`cities.field.region`)}/>

                            <TextInput
                                id="region"
                                type="text"
                                name="region"
                                value={data.region}
                                className="mt-1 block w-full"
                                onChange={(e) => setData('region', e.target.value)}
                            />

                            <InputError message={errors.region} className="mt-2"/>
                        </div>

                        <div className="mt-4">
                            <InputLabel htmlFor="name" className="dark:text-gray-300" value={t(`cities.field.name`)}/>

                            <TextInput
                                id="name"
                                type="text"
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full"
                                onChange={(e) => setData('name', e.target.value)}
                            />

                            <InputError message={errors.name} className="mt-2"/>
                        </div>

                        <div className="mt-4 flex">
                            <PrimaryButton className="mx-auto" disabled={processing}>
                                {t(`operations.create`)}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
