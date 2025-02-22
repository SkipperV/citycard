import {useEffect} from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import {Head, Link, useForm} from '@inertiajs/react';
import {useTranslation} from "react-i18next";

export default function Login({status}) {
    const {t} = useTranslation();

    const {data, setData, post, processing, errors, reset} = useForm({
        login: '',
        password: '',
        remember: false
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <GuestLayout>
            <Head title={t('auth.login_title')}/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <form onSubmit={submit}>
                <div className="mt-4">
                    <InputLabel htmlFor="login" className="dark:text-gray-300" value={t('auth.phone_number')}/>

                    <TextInput
                        id="login"
                        type="text"
                        name="login"
                        value={data.login}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('login', e.target.value)}
                    />

                    <InputError message={errors.login} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" className="dark:text-gray-300" value={t('auth.password')}/>

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2"/>
                </div>

                <div className="block mt-4">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                        />
                        <span className="ms-2 text-sm text-gray-600 dark:text-gray-300">{t('auth.remember_me')}</span>
                    </label>
                </div>

                <div className="flex items-center justify-end mt-4">
                    <Link
                        href={route('register')}
                        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-gray-400 dark:hover:text-gray-200"
                    >
                        {t('auth.no_account')}
                    </Link>

                    <PrimaryButton className="ms-4 dark:bg-gray-700 dark:hover:bg-gray-600" disabled={processing}>
                        {t('auth.log_in')}
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
